<?php
include_once "includes/init.php";
include_once "includes/autoload.lib.php";
include_once 'includes/View/header.php';
?>
<section class="row mt-10">
    <div class="col-m-3 col-3 menu border-1 border-round text-m-center">
        <nav>
            <ul>
            <li class="border-round"><a href="<?php echo $url; ?>">Home</a></li>
            <li class="border-round"><a href="<?php echo $url; ?>blogs.php">Blogs</a></li>
            <li class="border-round"><a href="<?php echo $url; ?>new.php">Whats New</a></li>
            <li class="border-round"><a href="<?php echo $url; ?>about.php">About</a></li>
            </ul>
        </nav>
    </div>
    <div class="col-m-6 col-6 text-center">
        <h1 class="border-round border-1">McMay.Sr Blog | Welcome.</h1>
        <div class="border-1 border-round mt-5 row">
            <div class="main-blog-pic col-7 col-m-7">
                <img src="hotspot/indexd.jpg" alt="blogmcmay.sr">
            </div>
            <div class="col-5 col-m-5 text-center">
                <p>hjjh jhhkj jknjn knjkn knkjn knn mnj j jhhhj jnhb nvghv  gvy hgvhvn hvgh</p>
            </div>
        </div>
    </div>
    <div class="col-m-3 col-3 text-m-center border-1 border-round">
        <h2>Ads Here.</h2>
        <div class="border-1 border-round p-4">
            <img src="" alt="cybehad llc">
            <p>Cybehad LLC, <small>Number one web seller in uganda</small></p>
        </div>
        <div class="border-1 border-round mt-5 p-4">
            <img src="" alt="genuine gadgets uganda">
            <p>Genuine Gadgets Uganda, <small>Number one phone seller in uganda</small></p>
        </div>
    </div>
</section>
<?php
include_once 'includes/View/footer.php';