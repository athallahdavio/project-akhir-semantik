<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapbook - Home</title>
    
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c3c1353c4c.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        require_once("sparqllib.php");
        $searchInput = "" ;
        $filter = "" ;
        
        if (isset($_POST['search'])) {
            $searchInput = $_POST['search'];
            $data = sparql_get(
            "http://localhost:3030/laptopcatalog",
            "
            prefix d:<http://www.semanticweb.org/athal/ontologies/2024/4/laptop#>

            SELECT ?LaptopName ?LaptopModel ?LaptopPrice ?LaptopType ?BrandName ?OSName ?ProcessorBrand ?ProcessorName ?GPUName ?RAMType ?RAMSize ?StorageType ?StorageSize
            WHERE {
                ?lptp	d:LaptopName ?LaptopName;
                        d:LaptopModel ?LaptopModel;
                        d:LaptopPrice ?LaptopPrice;
                        d:LaptopType ?LaptopType;
                        d:hasBrand ?brnd;
                        d:hasOS ?os;
                        d:hasProcessor ?prc;
                        d:hasGPU ?gpu;
                        d:hasRAM ?ram;
                        d:hasStorage ?strg.
                        
                ?brnd	d:BrandName ?BrandName.
                ?os		d:OSName ?OSName.
                ?prc	d:ProcessorBrand ?ProcessorBrand;
                        d:ProcessorName ?ProcessorName.
                ?gpu	d:GPUName ?GPUName.
                ?ram	d:RAMType ?RAMType;
                        d:RAMSize ?RAMSize.
                ?strg	d:StorageType ?StorageType;
                        d:StorageSize ?StorageSize.
                FILTER (
                    regex(?LaptopName, '$searchInput', 'i') || 
                    regex(?LaptopModel, '$searchInput', 'i') || 
                    regex(?LaptopPrice, '$searchInput', 'i') || 
                    regex(?LaptopType, '$searchInput', 'i') || 
                    regex(?BrandName, '$searchInput', 'i') || 
                    regex(?OSName, '$searchInput', 'i') || 
                    regex(?ProcessorBrand, '$searchInput', 'i') || 
                    regex(?ProcessorName, '$searchInput', 'i') || 
                    regex(?GPUName, '$searchInput', 'i') || 
                    regex(?RAMType, '$searchInput', 'i') || 
                    regex(?RAMSize, '$searchInput', 'i') || 
                    regex(?StorageType, '$searchInput', 'i') || 
                    regex(?StorageSize, '$searchInput', 'i')
                )
            }
            "
            );
        } else {
            $data = sparql_get(
            "http://localhost:3030/laptopcatalog",
            "
            prefix d:<http://www.semanticweb.org/athal/ontologies/2024/4/laptop#>

            SELECT ?LaptopName ?LaptopModel ?LaptopPrice ?LaptopType ?BrandName ?OSName ?ProcessorBrand ?ProcessorName ?GPUName ?RAMType ?RAMSize ?StorageType ?StorageSize
            WHERE {
                ?lptp	d:LaptopName ?LaptopName;
                        d:LaptopModel ?LaptopModel;
                        d:LaptopPrice ?LaptopPrice;
                        d:LaptopType ?LaptopType;
                        d:hasBrand ?brnd;
                        d:hasOS ?os;
                        d:hasProcessor ?prc;
                        d:hasGPU ?gpu;
                        d:hasRAM ?ram;
                        d:hasStorage ?strg.

                ?brnd	d:BrandName ?BrandName.
                ?os		d:OSName ?OSName.
                ?prc	d:ProcessorBrand ?ProcessorBrand;
                        d:ProcessorName ?ProcessorName.
                ?gpu	d:GPUName ?GPUName.
                ?ram	d:RAMType ?RAMType;
                        d:RAMSize ?RAMSize.
                ?strg	d:StorageType ?StorageType;
                        d:StorageSize ?StorageSize.
            }
            "
            );
        }

        if (!isset($data)) {
            print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
        }
    ?>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dark sticky-top">
        <div class="container container-fluid">
            <a class="navbar-brand" href="index.php"><img src="src/img/logo-nobg.png" style="width:50px" alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 h5">
                    <li class="nav-item px-2">
                        <a class="nav-link active text-white" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link text-white" href="about.php">About</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" action="" method="post" id="search" name="search">
                    <input class="form-control me-2" type="search" placeholder="Ketik keyword disini" aria-label="Search" name="search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Body -->
    <div class="container container-fluid my-3">
        <?php
            if ($searchInput != NULL) {
                ?> 
                    <i class="fa-solid fa-magnifying-glass"></i><span>Menampilkan hasil pencarian untuk <b>"<?php echo $searchInput; ?>"</b></span> 
                <?php
            }
        ?>
        <table class="table table-bordered table-hover text-center table-responsive">
            <thead class="table-dark align-middle">
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Merek</th>
                    <th>Model</th>
                    <th>Harga</th>
                    <th>Tipe</th>
                    <th>OS</th>
                    <th>Merek Processor</th>
                    <th>Processor</th>
                    <th>GPU</th>
                    <th>Tipe RAM</th>
                    <th>Ukuran RAM</th>
                    <th>Tipe Srotage</th>
                    <th>Ukuran RAM</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                <?php $i = 0; ?>
                <?php foreach ($data as $data) : ?>
                    <td><?= ++$i ?></td>
                    <td><?= $data['LaptopName'] ?></td>
                    <td><?= $data['BrandName'] ?></td>
                    <td><?= $data['LaptopModel'] ?></td>
                    <td><?= $data['LaptopPrice'] ?></td>
                    <td><?= $data['LaptopType'] ?></td>
                    <td><?= $data['OSName'] ?></td>
                    <td><?= $data['ProcessorBrand'] ?></td>
                    <td><?= $data['ProcessorName'] ?></td>
                    <td><?= $data['GPUName'] ?></td>
                    <td><?= $data['RAMType'] ?></td>
                    <td><?= $data['RAMSize'] ?></td>
                    <td><?= $data['StorageType'] ?></td>
                    <td><?= $data['StorageSize'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <?php
        if ($searchInput != NULL) {
            ?> 
                <footer class="footer text-light text-center bg-dark pb-1 fixed-bottom">
                    <p>Copyright &copy; All rights reserved -<img src="src/img/logo-nobg.png" style="width:75px" alt="Logo"></p>
                </footer>
            <?php
        } else {
            ?>
                <footer class="footer text-light text-center bg-dark pb-1">
                    <p>Copyright &copy; All rights reserved -<img src="src/img/logo-nobg.png" style="width:75px" alt="Logo"></p>
                </footer>
            <?php
        }
    ?>
</body>
</html>