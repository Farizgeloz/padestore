<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tproduk;
use App\Models\Tprodukfavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProdukApiController extends Controller
{
    // ambil semua produk
    public function index()
    {
        $produk = Tproduk::orderBy('id_produk', 'DESC')->get();

        $produk->map(function ($item) {
            $item->gambar = $item->gambar 
                ? asset('storage/produk/' . $item->gambar)
                : null;
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar Produk',
            'data' => $produk
        ]);
    }

    public function indexPaging(Request $request)
    {
        $limit  = $request->get('limit', 10);
        $page   = $request->get('page', 1);
        $search = trim($request->get('search', ''));

        $filter = (int) $request->get('filter', 0);

        $query = Tproduk::withSum(['pesanans as total_terjual' => function ($q) {
            $q->where('status', 'selesai');
        }], 'qty');

        // ===== SEARCH =====
        if ($search !== '') {
            $query->where('nama_produk', 'like', "%{$search}%");
        }

        // ===== FILTER =====
        switch ($filter) {

            case 0: // Terbaru
                $query->orderBy('updated_at', 'desc');
                break;

            case 1: // Terlaris
                $query->orderBy('total_terjual', 'desc');
                break;

            case 2: // Harga Tertinggi
                $query->orderBy('harga_retail', 'desc');
                break;

            case 3: // Harga Terendah
                $query->orderBy('harga_retail', 'asc');
                break;

            case 4: // Stok Terbanyak
                $query->orderBy('sisa_stok', 'desc');
                break;

            case 5: // Stok Tersedikit
                $query->orderBy('sisa_stok', 'asc');
                break;

            default: // Semua
                $query->orderBy('updated_at', 'desc');
                break;
        }

        // ===== PAGINATE =====
        $produk = $query->paginate($limit, ['*'], 'page', $page);

        // ===== FORMAT DATA =====
        $produk->getCollection()->transform(function ($item) {
            $item->gambar = $item->gambar
                ? asset('storage/produk/' . $item->gambar)
                : null;

            $item->total_terjual = $item->total_terjual ?? 0;

            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar Produk',
            'data' => $produk->items(),
            'pagination' => [
                'current_page' => $produk->currentPage(),
                'last_page'    => $produk->lastPage(),
                'per_page'     => $produk->perPage(),
                'total'        => $produk->total(),
            ]
        ]);
    }

    

    public function show($id)
    {
        $produk = Tproduk::leftJoin('tprodukfavorites', 'tprodukfavorites.produk_id', '=', 'tproduks.id_produk')
            ->select(
                'tproduks.*',
                DB::raw('CASE WHEN tprodukfavorites.produk_id IS NULL THEN "tidak" ELSE "ada" END as favorit')
            )
            ->where('tproduks.id_produk', $id)
            ->first();

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        // Ubah path gambar langsung
        $produk->gambar = $produk->gambar
            ? asset('storage/produk/' . $produk->gambar)
            : null;

        return response()->json([
            'success' => true,
            'data' => $produk
        ]);
    }

    // tambah produk
    public function store(Request $request)
    {
        $request->validate([
            "barcode" => 'required',
            "nama_produk" => 'required',
            "harga_retail" => 'required|integer|min:0',
            "sisa_stok" => 'required|integer|min:0'
        ]);

        DB::transaction(function() use ($request, &$produk) {
            $produk = Tproduk::create([
                'barcode' => $request->barcode,
                'nama_produk' => $request->nama_produk,
                'harga_retail' => $request->harga_retail,
                'sisa_stok' => $request->sisa_stok,
                'status' => $request->status ?? 'Aktif'
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan',
            'data' => $produk
        ]);
    }

    // update produk
    public function update(Request $request, $id)
    {
        $favorit = $request->favorit; // "ada" / "tidak"
        
        $produk = Tproduk::find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $request->validate([
            "barcode" => 'required',
            "nama_produk" => 'required',
            "harga_retail" => 'required|integer|min:0',
        ]);

        DB::transaction(function() use ($request, $produk, $favorit) {
            // Update data produk
            $produk->update([
                'barcode' => $request->barcode,
                'nama_produk' => $request->nama_produk,
                'harga_retail' => $request->harga_retail,
            ]);

            if ($favorit === 'ada') {
                $exists = DB::table('tprodukfavorites')
                    ->where('produk_id', $produk->id_produk)
                    ->exists();

                if (!$exists) {
                    $count = DB::table('tprodukfavorites')->count();

                    if ($count >= 6) {
                        // Hapus record paling lama
                        $oldest = DB::table('tprodukfavorites')
                            ->orderBy('created_at', 'asc')
                            ->first();

                        if ($oldest) {
                            DB::table('tprodukfavorites')
                                ->where('produk_id', $oldest->produk_id)
                                ->delete();
                        }
                    }

                    // Insert produk favorit baru
                    DB::table('tprodukfavorites')->insert([
                        'produk_id' => $produk->id_produk,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } else {
                // Jika "tidak", hapus dari favorit
                DB::table('tprodukfavorites')
                    ->where('produk_id', $produk->id_produk)
                    ->delete();
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diupdate',
            'data' => $produk
        ]);
    }

    public function storemultipart(Request $request)
    {
        $favorit = $request->favorit; // "ada" / "tidak"

        $request->validate([
            'barcode' => 'required',
            'nama_produk' => 'required',
            'harga_retail' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        DB::beginTransaction();

        try {
            $gambar = null;

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('produk', $filename);
                $gambar = $filename;
            }

            $produk = Tproduk::create([
                'barcode' => $request->barcode,
                'nama_produk' => $request->nama_produk,
                'harga_retail' => $request->harga_retail,
                'sisa_stok' => $request->sisa_stok ?? 0,
                'gambar' => $gambar,
                'status' => $request->status ?? 'Aktif',
                'tanggal' => now()
            ]);

            // --- Handle favorit max 6 ---
            if ($favorit === 'ada') {
                $exists = DB::table('tprodukfavorites')
                    ->where('produk_id', $produk->id_produk)
                    ->exists();

                if (!$exists) {
                    $count = DB::table('tprodukfavorites')->count();

                    if ($count >= 6) {
                        $oldest = DB::table('tprodukfavorites')
                            ->orderBy('tanggal', 'asc')
                            ->first();

                        if ($oldest) {
                            DB::table('tprodukfavorites')
                                ->where('produk_id', $oldest->produk_id)
                                ->delete();
                        }
                    }

                    DB::table('tprodukfavorites')->insert([
                        'produk_id' => $produk->id_produk,
                        'tanggal' => now()
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil disimpan',
                'data' => $produk
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function updatemultipart(Request $request, $id)
    {
        $favorit = $request->favorit; // "ada" / "tidak"

        $produk = Tproduk::find($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'barcode' => 'required',
            'nama_produk' => 'required',
            'harga_retail' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        DB::beginTransaction();

        try {
            $produk->barcode = $request->barcode;
            $produk->nama_produk = $request->nama_produk;
            $produk->harga_retail = $request->harga_retail;

            /* if ($request->has('sisa_stok')) {
                $produk->sisa_stok = $request->sisa_stok;
            } */

            if ($request->has('tanggal')) {
                $produk->tanggal = $request->tanggal;
            }

            // Upload gambar
            if ($request->hasFile('gambar')) {
                if ($produk->gambar && Storage::exists('produk/' . $produk->gambar)) {
                    Storage::delete('produk/' . $produk->gambar);
                }

                $file = $request->file('gambar');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('produk', $filename);

                $produk->gambar = $filename;
            }

            $produk->save();

            // --- Handle favorit max 6 ---
            if ($favorit === 'ada') {
                $exists = DB::table('tprodukfavorites')
                    ->where('produk_id', $produk->id_produk)
                    ->exists();

                if (!$exists) {
                    $count = DB::table('tprodukfavorites')->count();

                    if ($count >= 6) {
                        $oldest = DB::table('tprodukfavorites')
                            ->orderBy('tanggal', 'asc')
                            ->first();

                        if ($oldest) {
                            DB::table('tprodukfavorites')
                                ->where('produk_id', $oldest->produk_id)
                                ->delete();
                        }
                    }

                    DB::table('tprodukfavorites')->insert([
                        'produk_id' => $produk->id_produk,
                        'tanggal' => now()
                    ]);
                }
            } else {
                // Jika "tidak", hapus dari favorit
                DB::table('tprodukfavorites')
                    ->where('produk_id', $produk->id_produk)
                    ->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diupdate',
                'data' => $produk
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // hapus produk
    public function destroy($id)
    {
        $produk = Tproduk::findOrFail($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        // Cek apakah produk terkait dengan pesanan
        if ($produk->pesanans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak bisa dihapus karena ada pesanan terkait'
            ], 400);
        }

        DB::transaction(function() use ($produk) {
            
            $produk->delete();

            if ($produk->gambar && Storage::exists('produk/' . $produk->gambar)) {
                Storage::delete('produk/' . $produk->gambar);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus'
        ]);
    }
}