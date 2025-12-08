<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $lowStockProducts = Product::where('stock', '<', 5)->count();
        
        return view('admin_dashboard', compact('totalProducts', 'totalUsers', 'lowStockProducts'));
    }

    public function products()
    {
        $products = Product::paginate(10);
        return view('admin_produtos', compact('products'));
    }

    public function createProduct()
    {
        return view('admin_cadastrar_produto');
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'text' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:feminino,masculino',
            'brand' => 'nullable|string|max:100',
            'color' => 'nullable|string|in:ouro,prata,neutro',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ], [
            'name.required' => 'Nome do produto é obrigatório',
            'description.required' => 'Descrição é obrigatória',
            'price.required' => 'Preço é obrigatório',
            'category.required' => 'Categoria é obrigatória',
            'stock.required' => 'Estoque é obrigatório',
            'image.image' => 'O arquivo deve ser uma imagem',
            'image.max' => 'A imagem não pode ser maior que 2MB',
        ]);

        try {
            // Upload de imagem
            if ($request->hasFile('image')) {
                // Garante que o diretório existe
                $imgPath = public_path('img');
                if (!file_exists($imgPath)) {
                    mkdir($imgPath, 0755, true);
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move($imgPath, $imageName);
                $validated['image'] = $imageName;
            } else {
                // Auto-atribuir imagem baseada no nome do produto
                $validated['image'] = $this->autoAssignImage($validated['name'], $validated['category']);
            }

            Product::create($validated);
            return redirect()->route('adm-produto')->with('success', 'Produto criado com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao criar produto: ' . $e->getMessage());
        }
    }

    /**
     * Auto-atribui uma imagem baseada no tipo de produto
     */
    private function autoAssignImage($name, $category)
    {
        $nameLower = mb_strtolower($name);
        
        // Verifica o tipo de produto pelo nome
        if (str_contains($nameLower, 'anel')) {
            return 'anel-safira-azul.webp';
        } elseif (str_contains($nameLower, 'colar')) {
            return 'colar-corrente-fina.webp';
        } elseif (str_contains($nameLower, 'brinco')) {
            return 'anel-safira-azul.webp'; // Fallback
        } elseif (str_contains($nameLower, 'pulseira')) {
            return 'anel-ouro-rosa.webp'; // Fallback
        } elseif (str_contains($nameLower, 'relógio') || str_contains($nameLower, 'relogio')) {
            return 'relogio1.png';
        } elseif (str_contains($nameLower, 'corrente')) {
            return 'colar-corrente-fina.webp';
        }
        
        // Imagem padrão baseada na categoria
        return $category === 'feminino' ? 'anel-safira-azul.webp' : 'relogio1.png';
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin_editar_produto', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'text' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:feminino,masculino',
            'brand' => 'nullable|string|max:100',
            'color' => 'nullable|string|in:ouro,prata,neutro',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        try {
            // Upload de nova imagem
            if ($request->hasFile('image')) {
                // Remove imagem antiga se não for padrão
                if ($product->image && file_exists(public_path('img/' . $product->image))) {
                    $defaultImages = ['anel-safira-azul.webp', 'colar-corrente-fina.webp', 'relogio1.png', 'anel-ouro-rosa.webp'];
                    if (!in_array($product->image, $defaultImages)) {
                        @unlink(public_path('img/' . $product->image));
                    }
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('img'), $imageName);
                $validated['image'] = $imageName;
            }

            $product->update($validated);
            return redirect()->route('adm-produto')->with('success', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao atualizar produto: ' . $e->getMessage());
        }
    }

    public function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect()->route('adm-produto')->with('success', 'Produto deletado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao deletar produto: ' . $e->getMessage());
        }
    }

    public function users()
    {
        $users = User::paginate(10);
        return view('admin_usuarios', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin_editar_usuario', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'is_admin' => 'nullable|boolean',
        ]);

        try {
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            
            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
            }
            
            if (isset($validated['is_admin'])) {
                $user->is_admin = $validated['is_admin'];
            }
            
            $user->save();
            
            return redirect()->route('adm-usuarios')->with('success', 'Usuário atualizado com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao atualizar usuário: ' . $e->getMessage());
        }
    }

    public function deleteUser($id)
    {
        try {
            if ($id === Auth::id()) {
                return back()->with('error', 'Você não pode deletar sua própria conta!');
            }
            
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('adm-usuarios')->with('success', 'Usuário deletado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao deletar usuário: ' . $e->getMessage());
        }
    }

    public function createAdmin()
    {
        return view('admin_criar_usuario');
    }

    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'is_admin' => 'nullable|boolean',
        ]);

        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'is_admin' => isset($validated['is_admin']) ? $validated['is_admin'] : false,
            ]);
            
            return redirect()->route('adm-usuarios')->with('success', 'Usuário criado com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao criar usuário: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return redirect()->route('adm-dashboard');
        }

        // Buscar produtos
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('brand', 'LIKE', "%{$query}%")
            ->orWhere('category', 'LIKE', "%{$query}%")
            ->paginate(10);

        // Buscar usuários
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('admin_search_results', compact('products', 'users', 'query'));
    }
}
