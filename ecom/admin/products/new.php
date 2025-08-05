<?php
require __DIR__ . "/../../../functions.php";

$pdo = require __DIR__ . "/../../../connection.php";

try {
    $destination = "";

    $categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['submit'])) {
        $sql = "INSERT INTO products (name, price, category_id, description, image, stock, is_active) VALUES (:name, :price, :category_id, :description, :image, :stock, :is_active)";
        $stmt = $pdo->prepare($sql);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Config

            $uploadDir = __DIR__ . './../../../assets/uploads/';
            $relPath = '/assets/uploads/';
            $maxFileSize = 2 * 1024 * 1024; // 2MB
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

            if (isset($_FILES['image'])) {
                $fileTmp = $_FILES['image']['tmp_name'];
                $fileName = basename($_FILES['image']['name']);
                $fileSize = $_FILES['image']['size'];
                $fileType = mime_content_type($fileTmp);
                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

                // Validate file type
                if (!in_array($fileType, $allowedTypes)) {
                    echo "Invalid file type.";
                    exit;
                }

                // Validate size
                if ($fileSize > $maxFileSize) {
                    echo "File is too large.";
                    exit;
                }

                // Rename file (avoid name collisions)
                $newFileName = uniqid("img_", true) . "." . $fileExt;
                $relDestination = $relPath . $newFileName;
                $destination = $uploadDir . $newFileName;

                // Move the uploaded file
                if (move_uploaded_file($fileTmp, $destination)) {
                    echo "Image uploaded successfully.";
                } else {
                    echo "Failed to move the uploaded file.";
                }
            } else {
                echo "No file uploaded or there was an upload error.";
            }
        }

        $stmt->execute([
            ':name' => $_POST['name'],
            ':price' => $_POST['price'],
            ':category_id' => $_POST['category_id'],
            ':description' => $_POST['description'],
            ':image' => $relDestination,
            ':stock' => $_POST['stock'],
            ':is_active' => $_POST['is_active']
        ]);
    }
} catch (PDOException $e) {
    echo "Something went wrong: " . $e->getMessage() . "\n";
    die();
}

?>

<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PHP Ecom | Dashboard</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
        name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance." />
    <meta
        name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant" />
    <!--end::Primary Meta Tags-->
    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="<?php echo asset("assets/admin/css/adminlte.css") ?>" as="style" />
    <!--end::Accessibility Features-->
    <!--begin::Fonts-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
        crossorigin="anonymous"
        media="print"
        onload="this.media='all'" />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="<?php echo asset("/assets/admin/css/adminlte.css") ?>" />
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
        crossorigin="anonymous" />
    <!-- jsvectormap -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" />

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">

    <style>
        label.error {
            color: red;
            font-size: 14px;
            margin-top: 4px;
            display: block;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <?php include "./../includes/header.php"; ?>
        <!--end::Header-->
        <!--begin::Sidebar-->
        <?php include "./../includes/sidebar.php"; ?>
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Products</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="./dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Products</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <!--begin::App Content-->
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <div class="card card-info card-outline mb-4">
                        <!--begin::Header-->
                        <div class="card-header">
                            <div class="card-title">New Product</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Form-->
                        <form id="new-product-form" novalidate method="POST" enctype="multipart/form-data">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Row-->
                                <div class="row g-3">
                                    <!--begin::Col-->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="name"
                                            name="name"
                                            required />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="price" class="form-label">Price</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="price"
                                            name="price"
                                            required />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select
                                            class="form-control"
                                            id="category_id"
                                            name="category_id"
                                            required>
                                            <?php foreach ($categories as $category) : ?>
                                                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea
                                            class="form-control"
                                            id="description"
                                            name="description"
                                            required>
                                        </textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="image" class="form-label">Image</label>
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="image"
                                            name="image"
                                            required />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="stock" class="form-label">Stock</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="stock"
                                            name="stock"
                                            required />
                                    </div>
                                    <div class="col-md-6">
                                        <label>
                                            <input type="checkbox" name="is_active" value="1" checked>
                                            Active
                                        </label>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Body-->
                            <!--begin::Footer-->
                            <div class="card-footer">
                                <input name="submit" value="Submit" class="btn btn-info" type="submit" />
                            </div>
                            <!--end::Footer-->
                        </form>
                        <!--end::Form-->
                        <!--begin::JavaScript-->

                        <!--end::JavaScript-->
                    </div>
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->
        <!--begin::Footer-->
        <?php include "./../includes/footer.php"; ?>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="<?php echo asset("/assets/admin/js/adminlte.js") ?>"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- jsvectormap -->
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#categories-table').DataTable();

            $('#description').summernote({
                height: 300, // set editor height in pixels
                minHeight: 200, // set minimum height of editor
                maxHeight: 500 // set maximum height of editor
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

    <script>
        (() => {
            $("#new-product-form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    price: {
                        required: true,
                        min: 0
                    },
                    category_id: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    image: {
                        required: true
                    },
                    stock: {
                        required: true,
                        min: 0
                    },
                    is_active: {
                        required: true
                    }
                },
                submitHandler: function(form) {
                    let fileData = $('#new-product-form').prop('files');
                    let formData = new FormData(form);

                    formData.append('file', fileData);

                    $.ajax({
                        url: '<?php echo route("ecom/admin/products/new.php"); ?>',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Product created successfully!',
                            });
                            form.reset();
                        },
                        error: function(xhr, status, error) {
                            console.log('error');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something went wrong. Please try again.',
                            });
                        }
                    });

                    return false;
                }
            });
        })();
    </script>

    <!--end::Script-->
</body>
<!--end::Body-->

</html>