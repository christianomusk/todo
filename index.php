<?php 
$todos = [];
if(file_exists('todo.txt')) {
	$file = file_get_contents('todo.txt');
	$todos = unserialize($file);
}

if(isset($_POST['kirim'])) {
	$value = $_POST['newTodo'];
	$todos[] = ['value' => $value, 'status' => 0];
	saveData($todos);
}

if(isset($_GET['status'])) {
	$todos[$_GET['key']]['status'] = $_GET['status'];
	saveData($todos);
}

if(isset($_GET['clear'])) {
	unset($todos[$_GET['key']]);
	saveData($todos);
}

if(isset($_POST['hapus'])) {
	$file = 'todo.txt';
	if (file_exists($file)) {
		unlink($file);
	}
	unset($todos); // menghapus semua data dari array todos
	header('Location: index.php'); // redirect ke halaman utama
}

function saveData($todos) {
	file_put_contents('todo.txt', serialize($todos));
	header('Location: index.php');
}

?>
<h1>Todo App</h1>

<form action="" method="POST">

	<label>Daftar Kegiatan Hari ini<label><br>

	<input type="text" name="newTodo" autocomplete="off">

	<button type="submit" name="kirim">Simpan</button>
	<button type="submit" name="hapus">Clear Data</button>

</form>

<ul>

	<?php foreach($todos as $key => $todo): ?>
		<li>

			<input type="checkbox" name="todo" onclick="window.location.href = 'index.php?status=<?= ($todo['status'] == 1) ? 0 : 1 ?>&key=<?= $key ?>'" <?php if($todo['status'] == 1) echo 'checked'; ?>>

			<?php if($todo['status'] == 1): ?>
				<label><del><?= $todo['value'] ?> </del> | <a href='index.php?clear=1&key=<?= $key ?>' onclick="return confirm('Data akan dihapus?')">hapus</a></label>
			<?php else : ?>
				<label><?= $todo['value'] ?> | <a href='index.php?clear=1&key=<?= $key ?>' onclick="return confirm('Data akan dihapus?')">hapus</a></a></label>
			<?php endif; ?>
			

		</li>
	<?php endforeach; ?>


</ul>