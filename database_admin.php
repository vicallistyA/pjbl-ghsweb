<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>E-commerce Admin - Data Management</title>
  <!-- TailwindCSS CDN for utility-first CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Custom styles for subtle shadows and transitions */
    .card {
      @apply bg-white rounded-lg shadow p-6 mb-8;
    }
    .header {
      @apply sticky top-0 bg-white shadow-md z-50;
    }
    .btn-primary {
      @apply bg-black text-white px-4 py-2 rounded shadow hover:bg-gray-800 transition;
    }
    .btn-secondary {
      @apply border border-gray-500 text-gray-700 px-4 py-2 rounded hover:bg-gray-100 transition;
    }
    .btn-danger {
      @apply bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition;
    }
    .input-field {
      @apply border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-black focus:border-black;
    }
    /* Table styles */
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      @apply border-b border-gray-200 text-left px-4 py-3;
    }
    th {
      @apply bg-gray-50 font-semibold text-gray-700;
    }
    tr:hover {
      @apply bg-gray-50;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans tracking-wide text-gray-700">

<header class="header px-8 py-4 flex justify-between items-center max-w-[1200px] mx-auto">
  <h1 class="text-3xl font-extrabold">E-commerce Admin</h1>
  <nav>
    <a href="?page=products" class="mr-6 hover:text-black transition font-semibold">Products</a>
    <a href="?page=categories" class="mr-6 hover:text-black transition font-semibold">Categories</a>
    <a href="?page=orders" class="hover:text-black transition font-semibold">Orders</a>
  </nav>
</header>

<main class="max-w-[1200px] mx-auto p-6">

<?php
$host = 'localhost';
$db   = 'database_ghs';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo "<div class='card'><h2 class='text-xl font-bold mb-4 text-red-600'>Database connection failed</h2><p>" . htmlspecialchars($e->getMessage()) . "</p></div>";
    exit;
}
// Helper function to sanitize input
function clean($str) {
    return htmlspecialchars(trim($str));
}

$page = $_GET['page'] ?? 'products';
$action = $_GET['action'] ?? null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($page === 'products') {
        if ($action === 'add') {
            $name = clean($_POST['name'] ?? '');
            $description = clean($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $category_id = intval($_POST['category_id'] ?? 0);

            if ($name === '' || $price <= 0) {
                $error = "Product name and positive price are required.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO products (name, description, price, category_id) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $description, $price, $category_id ? $category_id : null]);
                header("Location: ?page=products");
                exit;
            }
        } elseif ($action === 'edit' && $id) {
            $name = clean($_POST['name'] ?? '');
            $description = clean($_POST['description'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $category_id = intval($_POST['category_id'] ?? 0);

            if ($name === '' || $price <= 0) {
                $error = "Product name and positive price are required.";
            } else {
                $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, category_id = ? WHERE id = ?");
                $stmt->execute([$name, $description, $price, $category_id ? $category_id : null, $id]);
                header("Location: ?page=products");
                exit;
            }
        }
    } elseif ($page === 'categories') {
        if ($action === 'add') {
            $name = clean($_POST['name'] ?? '');
            if ($name === '') {
                $error = "Category name is required.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
                $stmt->execute([$name]);
                header("Location: ?page=categories");
                exit;
            }
        } elseif ($action === 'edit' && $id) {
            $name = clean($_POST['name'] ?? '');
            if ($name === '') {
                $error = "Category name is required.";
            } else {
                $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
                $stmt->execute([$name, $id]);
                header("Location: ?page=categories");
                exit;
            }
        }
    } elseif ($page === 'orders') {
        if ($action === 'add') {
            $user_id = intval($_POST['user_id'] ?? 0);
            $product_id = intval($_POST['product_id'] ?? 0);
            $quantity = intval($_POST['quantity'] ?? 0);
            $status = clean($_POST['status'] ?? 'pending');

            if ($user_id <= 0 || $product_id <=0 || $quantity <= 0) {
                $error = "User ID, Product ID and positive quantity are required.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO orders (user_id, product_id, quantity, status) VALUES (?, ?, ?, ?)");
                $stmt->execute([$user_id, $product_id, $quantity, $status]);
                header("Location: ?page=orders");
                exit;
            }
        } elseif ($action === 'edit' && $id) {
            $user_id = intval($_POST['user_id'] ?? 0);
            $product_id = intval($_POST['product_id'] ?? 0);
            $quantity = intval($_POST['quantity'] ?? 0);
            $status = clean($_POST['status'] ?? 'pending');

            if ($user_id <= 0 || $product_id <=0 || $quantity <= 0) {
                $error = "User ID, Product ID and positive quantity are required.";
            } else {
                $stmt = $pdo->prepare("UPDATE orders SET user_id = ?, product_id = ?, quantity = ?, status = ? WHERE id = ?");
                $stmt->execute([$user_id, $product_id, $quantity, $status, $id]);
                header("Location: ?page=orders");
                exit;
            }
        }
    }
}

// Handle delete actions
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete']) && $id) {
    if ($page === 'products') {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: ?page=products");
        exit;
    } elseif ($page === 'categories') {
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: ?page=categories");
        exit;
    } elseif ($page === 'orders') {
        $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: ?page=orders");
        exit;
    }
}

// UI Rendering functions

function renderError($error) {
    if (!empty($error)) {
        echo "<div class='mb-4 p-4 rounded bg-red-100 text-red-700 font-semibold'>$error</div>";
    }
}

function renderProductsList($pdo) {
    echo "<h2 class='text-4xl font-extrabold mb-6'>Products</h2>";
    echo '<a href="?page=products&action=add" class="btn-primary mb-4 inline-block">Add New Product</a>';

    $stmt = $pdo->query("SELECT p.id, p.name, p.description, p.price, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC");
    $products = $stmt->fetchAll();

    echo "<div class='overflow-x-auto'>";
    echo "<table><thead><tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Category</th><th>Actions</th></tr></thead><tbody>";
    if (!$products) {
        echo "<tr><td colspan='6' class='text-center py-4'>No products found.</td></tr>";
    } else {
        foreach ($products as $p) {
            $desc = strlen($p['description']) > 50 ? htmlspecialchars(substr($p['description'],0,50)) . "…" : htmlspecialchars($p['description']);
            echo "<tr>
                <td>".$p['id']."</td>
                <td>".htmlspecialchars($p['name'])."</td>
                <td title='".htmlspecialchars($p['description'])."'>$desc</td>
                <td>$".number_format($p['price'],2)."</td>
                <td>".htmlspecialchars($p['category_name'] ?? '—')."</td>
                <td>
                  <a href='?page=products&action=edit&id={$p['id']}' class='btn-secondary mr-2'>Edit</a>
                  <a href='?page=products&delete=1&id={$p['id']}' class='btn-danger' onclick='return confirm(\"Delete this product?\")'>Delete</a>
                </td>
            </tr>";
        }
    }
    echo "</tbody></table></div>";
}

function renderProductForm($pdo, $action, $id=null, $error = null) {
    $product = ['name'=>'', 'description'=>'', 'price'=>'', 'category_id'=>0];
    if ($action === 'edit' && $id) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();
        if (!$product) {
            echo "<div class='card'><p>Product not found.</p></div>";
            return;
        }
    }
    renderError($error);
    echo "<h2 class='text-4xl font-extrabold mb-6'>" . ($action === 'edit' ? "Edit Product" : "Add New Product") . "</h2>";
    // Get categories for select dropdown
    $categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();

    ?>
    <form method="POST" class="max-w-lg">
      <label class="block mb-4">
        <span class="font-semibold">Name</span>
        <input type="text" name="name" value="<?=htmlspecialchars($product['name'])?>" class="input-field" required />
      </label>
      <label class="block mb-4">
        <span class="font-semibold">Description</span>
        <textarea name="description" rows="4" class="input-field"><?=htmlspecialchars($product['description'])?></textarea>
      </label>
      <label class="block mb-4">
        <span class="font-semibold">Price ($)</span>
        <input type="number" step="0.01" min="0" name="price" value="<?=htmlspecialchars($product['price'])?>" class="input-field" required />
      </label>
      <label class="block mb-6">
        <span class="font-semibold">Category</span>
        <select name="category_id" class="input-field">
          <option value="0">-- None --</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id']?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>><?=htmlspecialchars($cat['name'])?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <button type="submit" class="btn-primary">
        <?= $action === 'edit' ? "Update Product" : "Add Product" ?>
      </button>
      <a href="?page=products" class="btn-secondary ml-4">Cancel</a>
    </form>
    <?php
}

function renderCategoriesList($pdo) {
    echo "<h2 class='text-4xl font-extrabold mb-6'>Categories</h2>";
    echo '<a href="?page=categories&action=add" class="btn-primary mb-4 inline-block">Add New Category</a>';

    $stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
    $cats = $stmt->fetchAll();

    echo "<div class='overflow-x-auto'>";
    echo "<table><thead><tr><th>ID</th><th>Name</th><th>Actions</th></tr></thead><tbody>";
    if (!$cats) {
        echo "<tr><td colspan='3' class='text-center py-4'>No categories found.</td></tr>";
    } else {
        foreach ($cats as $c) {
            echo "<tr>
                <td>{$c['id']}</td>
                <td>".htmlspecialchars($c['name'])."</td>
                <td>
                  <a href='?page=categories&action=edit&id={$c['id']}' class='btn-secondary mr-2'>Edit</a>
                  <a href='?page=categories&delete=1&id={$c['id']}' class='btn-danger' onclick='return confirm(\"Delete this category?\")'>Delete</a>
                </td>
            </tr>";
        }
    }
    echo "</tbody></table></div>";
}

function renderCategoryForm($pdo, $action, $id=null, $error=null) {
    $category = ['name'=>''];
    if ($action === 'edit' && $id) {
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $category = $stmt->fetch();
        if (!$category) {
            echo "<div class='card'><p>Category not found.</p></div>";
            return;
        }
    }
    renderError($error);
    echo "<h2 class='text-4xl font-extrabold mb-6'>" . ($action === 'edit' ? "Edit Category" : "Add New Category") . "</h2>";
    ?>
    <form method="POST" class="max-w-lg">
      <label class="block mb-6">
        <span class="font-semibold">Name</span>
        <input type="text" name="name" value="<?=htmlspecialchars($category['name'])?>" class="input-field" required />
      </label>
      <button type="submit" class="btn-primary">
        <?= $action === 'edit' ? "Update Category" : "Add Category" ?>
      </button>
      <a href="?page=categories" class="btn-secondary ml-4">Cancel</a>
    </form>
    <?php
}

function renderOrdersList($pdo) {
    echo "<h2 class='text-4xl font-extrabold mb-6'>Orders</h2>";
    echo '<a href="?page=orders&action=add" class="btn-primary mb-4 inline-block">Add New Order</a>';

    // For demo: no user table, just user_id plain number
    $stmt = $pdo->query("SELECT o.id, o.user_id, o.product_id, o.quantity, o.status, p.name AS product_name FROM orders o LEFT JOIN products p ON o.product_id = p.id ORDER BY o.id DESC");
    $orders = $stmt->fetchAll();

    echo "<div class='overflow-x-auto'>";
    echo "<table><thead><tr><th>ID</th><th>User ID</th><th>Product</th><th>Quantity</th><th>Status</th><th>Actions</th></tr></thead><tbody>";
    if (!$orders) {
        echo "<tr><td colspan='6' class='text-center py-4'>No orders found.</td></tr>";
    } else {
        foreach ($orders as $o) {
            echo "<tr>
                <td>{$o['id']}</td>
                <td>{$o['user_id']}</td>
                <td>".htmlspecialchars($o['product_name'] ?? 'Unknown')."</td>
                <td>{$o['quantity']}</td>
                <td>".htmlspecialchars($o['status'])."</td>
                <td>
                  <a href='?page=orders&action=edit&id={$o['id']}' class='btn-secondary mr-2'>Edit</a>
                  <a href='?page=orders&delete=1&id={$o['id']}' class='btn-danger' onclick='return confirm(\"Delete this order?\")'>Delete</a>
                </td>
            </tr>";
        }
    }
    echo "</tbody></table></div>";
}

function renderOrderForm($pdo, $action, $id=null, $error=null) {
    $order = ['user_id'=>'', 'product_id'=>'', 'quantity'=>'', 'status'=>'pending'];
    if ($action === 'edit' && $id) {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        $order = $stmt->fetch();
        if (!$order) {
            echo "<div class='card'><p>Order not found.</p></div>";
            return;
        }
    }
    renderError($error);
    echo "<h2 class='text-4xl font-extrabold mb-6'>" . ($action === 'edit' ? "Edit Order" : "Add New Order") . "</h2>";

    // Fetch products for selection
    $products = $pdo->query("SELECT id, name FROM products ORDER BY name")->fetchAll();
    ?>
    <form method="POST" class="max-w-lg">
      <label class="block mb-4">
        <span class="font-semibold">User ID</span>
        <input type="number" min="1" name="user_id" value="<?=htmlspecialchars($order['user_id'])?>" class="input-field" required />
      </label>
      <label class="block mb-4">
        <span class="font-semibold">Product</span>
        <select name="product_id" class="input-field" required>
          <option value="">-- Select Product --</option>
          <?php foreach($products as $p): ?>
            <option value="<?= $p['id']?>" <?= $p['id'] == $order['product_id'] ? 'selected' : '' ?>><?=htmlspecialchars($p['name'])?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <label class="block mb-4">
        <span class="font-semibold">Quantity</span>
        <input type="number" min="1" name="quantity" value="<?=htmlspecialchars($order['quantity'])?>" class="input-field" required />
      </label>
      <label class="block mb-6">
        <span class="font-semibold">Status</span>
        <select name="status" class="input-field" required>
          <?php
            $statuses = ['pending', 'processing', 'completed', 'cancelled'];
            foreach($statuses as $statusOption) {
                $selected = ($order['status'] === $statusOption) ? 'selected' : '';
                echo "<option value='$statusOption' $selected>" . ucfirst($statusOption) . "</option>";
            }
          ?>
        </select>
      </label>
      <button type="submit" class="btn-primary">
        <?= $action === 'edit' ? "Update Order" : "Add Order" ?>
      </button>
      <a href="?page=orders" class="btn-secondary ml-4">Cancel</a>
    </form>
    <?php
}

// Page content controller
if ($page === 'products') {
    if ($action === 'add') {
        renderProductForm($pdo, 'add', null, $error ?? null);
    } elseif ($action === 'edit' && $id) {
        renderProductForm($pdo, 'edit', $id, $error ?? null);
    } else {
        renderProductsList($pdo);
    }
} elseif ($page === 'categories') {
    if ($action === 'add') {
        renderCategoryForm($pdo, 'add', null, $error ?? null);
    } elseif ($action === 'edit' && $id) {
        renderCategoryForm($pdo, 'edit', $id, $error ?? null);
    } else {
        renderCategoriesList($pdo);
    }
} elseif ($page === 'orders') {
    if ($action === 'add') {
        renderOrderForm($pdo, 'add', null, $error ?? null);
    } elseif ($action === 'edit' && $id) {
        renderOrderForm($pdo, 'edit', $id, $error ?? null);
    } else {
        renderOrdersList($pdo);
    }
} else {
    // Unknown page fallback
    echo "<div class='card'><h2 class='text-xl font-semibold'>Page not found</h2></div>";
}
?>

</main>

<footer class="text-center text-gray-500 text-sm p-6">
  &copy; <?=date('Y')?> E-commerce Admin
</footer>

</body>
</html>