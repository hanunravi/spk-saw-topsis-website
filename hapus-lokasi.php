<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1, 2)); ?>

<?php
$ada_error = false;
$result = '';

$id_lokasi = (isset($_GET['id'])) ? trim($_GET['id']) : '';

if(!$id_lokasi) {
	$ada_error = 'Maaf, data tidak dapat diproses.';
} else {
	$query = $pdo->prepare('SELECT id_lokasi FROM lokasi WHERE id_lokasi = :id_lokasi');
	$query->execute(array('id_lokasi' => $id_lokasi));
	$result = $query->fetch();
	
	if(empty($result)) {
		$ada_error = 'Maaf, data tidak dapat diproses.';
	} else {
		
		$handle = $pdo->prepare('DELETE FROM nilai_lokasi WHERE id_lokasi = :id_lokasi');				
		$handle->execute(array(
			'id_lokasi' => $result['id_lokasi']
		));
		$handle = $pdo->prepare('DELETE FROM lokasi WHERE id_lokasi = :id_lokasi');				
		$handle->execute(array(
			'id_lokasi' => $result['id_lokasi']
		));
		redirect_to('list-lokasi.php?status=sukses-hapus');
		
	}
}
?>

<?php
$judul_page = 'Hapus lokasi';
require_once('template-parts/header.php');
?>

	<div class="main-content-row">
	<div class="container clearfix">
	
		<?php include_once('template-parts/sidebar-lokasi.php'); ?>
	
		<div class="main-content the-content">
			<h1><?php echo $judul_page; ?></h1>
			
			<?php if($ada_error): ?>
			
				<?php echo '<p>'.$ada_error.'</p>'; ?>	
			
			<?php endif; ?>
			
		</div>
	
	</div><!-- .container -->
	</div><!-- .main-content-row -->


<?php
require_once('template-parts/footer.php');