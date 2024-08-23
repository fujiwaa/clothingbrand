<?php
session_start();
require '../../config.php';
$title = 'Kalender';

if ($_SESSION['user']) {
    $id = $_SESSION['user']['id'];
    $cek_user = $db->query("SELECT * FROM user WHERE id = '$id'");
    $data_user = mysqli_fetch_array($cek_user);
    
    if (isset($_POST['save'])) {
        $titlee = $_POST['title'];
        $start = $_POST['start'];
        
        if (empty($titlee) || empty($start)) {
            $pesan = "<div class='alert alert-danger'>Mohon mengisi semua input.</div>";
        } else {
            $insert = $db->query("INSERT INTO calender (title, start, created_at, updated_at) VALUES ('$titlee', '$start', '$datetime', '$datetime')");
            if ($insert) {
                $pesan = "<div class='alert alert-success'>Kalender Baru berhasil ditambahkan.</div>";
            } else {
                $pesan = "<div class='alert alert-danger'>Kalender Baru gagal ditambahkan, Sistem sedang error!</div>";
            }
        }
    }
    
    if (isset($_POST['change'])) {
        $calender_id = $_POST['id'];
        $titlee = $_POST['title'];
        $start = $_POST['start'];
        
        if (empty($titlee) || empty($start)) {
            $pesan = "<div class='alert alert-danger'>Mohon mengisi semua input.</div>";
        } else {
            $update = $db->query("UPDATE calender SET title = '$titlee', start = '$start', updated_at = '$datetime' WHERE id = '$calender_id'");
            if ($update) {
                $pesan = "<div class='alert alert-success'>Kalender berhasil diubah.</div>";
            } else {
                $pesan = "<div class='alert alert-danger'>Kalender gagal diubah, Sistem sedang error!</div>";
            }
        }
    }
    
    if (isset($_POST['delete'])) {
        $calender_id = $_POST['id'];
        
        $calender = mysqli_query($db, "SELECT * FROM calender WHERE id = '$calender_id'");
        $data_calender = mysqli_fetch_array($calender);
        
        $delete = $db->query("DELETE FROM calender WHERE id = '$calender_id'");
        if ($delete) {
            $pesan = "<div class='alert alert-success'>Kalender berhasil dihapus.</div>";
        } else {
            $pesan = "<div class='alert alert-success'>Kalender gagal dihapus, Sistem sedang error!</div>";
        }
    }
    
    $calender = $db->query("SELECT * FROM calender");
    
    $events = array();
    while ($data_calender = mysqli_fetch_assoc($calender)) {
        $event = array(
            'id' => $data_calender['id'],
            'title' => $data_calender['title'],
            'start' => $data_calender['start'],
        );
        array_push($events, $event);
    }
    $eventsJSON = json_encode($events);
    
    require '../../lib/admin/header.php';
?>
<div class="container-fluid p-0 vh-100 bg-body-secondary d-flex position-relative">

    <?php include '../../lib/admin/sidebar.php'; ?>

    <div class="main w-100 px-5 overflow-auto">

        <div class="top-nav d-flex justify-content-between pt-4 align-items-center">
            <h4>Kalender</h3>
                <div class="menu-group d-flex gap-3">
                    <a href="#" class="text-dark"><i class="fa-regular fa-calendar p-2"></i></a>
                    <a href="#" class="text-dark"><i class="fa-solid fa-bell p-2"></i></a>
                    <div>
                        <img src="<?= $web_baseurl ?>assets/images/profile/<?php echo $data_user['profile']; ?>" width="32">
                    </div>
                    <?php include '../../lib/admin/dropdown.php'; ?>
                </div>
        </div>

        <div class="content mt-5 mb-5 bg-white p-4">
            <?php
            if (isset($_POST['save']) OR isset($_POST['change']) OR isset($_POST['delete'])) {
                echo $pesan;
            }
            ?>
            
            <div class="mb-2 d-flex justify-content-end gap-2">
                <a href="#" class="btn btn-md bg-dongker btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"><i class="fa-solid fa-plus"></i> Tambah Jadwal</a>
            </div>
            <div id="calendar"></div>

        </div>

        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-5">
                    <div class="modal-header px-5 border-0">
                        <p class="modal-title fw-bold">Buat Jadwal</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 14px;"></button>
                    </div>
                    <div class="modal-body px-5">
                        <form method="post">
    
                            <div class="mb-3">
                                <input type="text" name="title" class="form-control border border-2 p-2 px-3 shadow-none rounded-3" placeholder="Agenda">
                            </div>
                            <div class="mb-3">
                                <input type="date" name="start" class="form-control border border-2 p-2 px-3 shadow-none rounded-3">
                            </div>
                            <div class="text-end mt-4">
                                <button class="btn rounded-3 bg-dongker w-50" name="save">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="modal fade" id="calenderModal" tabindex="-1" aria-labelledby="calenderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-5">
            <div class="modal-header px-5 border-0">
                <p class="modal-title fw-bold">Jadwal</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 14px;"></button>
            </div>
            <div class="modal-body px-5">
                <form method="POST">
                    <input type="hidden" name="id" id="calender-id">
                    <div class="mb-3">
                        <input type="text" name="title" id="calender-title" class="form-control border border-2 p-2 px-3 shadow-none rounded-3" placeholder="Agenda">
                    </div>
                    <div class="mb-3">
                        <input type="date" name="start" id="calender-start" class="form-control border border-2 p-2 px-3 shadow-none rounded-3">
                    </div>
                    <div class="mt-4 d-flex">
                        <button class="btn rounded-3 bg-dongker btn-outline-primary w-50 me-2" name="change">Ubah</button>
                        <button class="btn rounded-3 bg-danger w-50 text-white" name="delete">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include '../../lib/admin/footer.php';
} else {
    header("Location: ".$web_baseurl."profile");
}
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'UTC',
            locale: 'id',
            themeSystem: 'bootstrap',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            events: <?php echo $eventsJSON; ?>,
            eventClick: function(info) {
                $('#calender-id').val(info.event.id);
                $('#calender-title').val(info.event.title);
                $('#calender-start').val(info.event.startStr.slice(0, 10));
                $('#calenderModal').modal('show');
            }
        });

        calendar.render();
    });
</script>