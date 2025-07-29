<?php
include('koneksi.php');


$visi_query = "SELECT isi FROM visi";
$visi_result = $conn->query($visi_query);
$visi_text = "";
while ($row = $visi_result->fetch_assoc()) {
    $visi_text .= "<p>" . htmlspecialchars($row['isi']) . "</p>";
}


$misi_query = "SELECT isi FROM misi";
$misi_result = $conn->query($misi_query);
$misi = [];
while ($row = $misi_result->fetch_assoc()) {
    $misi[] = $row['isi'];
}
?>
<main class="main">
    <div class="page-title dark-background"></div>
    <div class="container my-5" data-aos="fade-up" data-aos-delay="200">
        <section id="visimisi" class="vision-mission mt-5">
            <div class="row">
                <div class="col-md-6">
                    <h3>VISI</h3>
                    <?php echo $visi_text; ?>
                </div>
                <div class="col-md-6">
                    <h3>MISI</h3>
                    <ul>
                        <?php
                        foreach ($misi as $misi_item) {
                            echo '<li>' . rtrim(htmlspecialchars($misi_item), '.') . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </section>
    </div>
</main>
<?php include('footer.html'); ?>
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>