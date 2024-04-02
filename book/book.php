<?php
session_start();

require_once __DIR__ . '../../backend/conection.php';


if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Fetch the user information for the given ID
    $sql = 'SELECT books.*, categories.title AS category_title, 
    CONCAT(authors.firstname, " ", authors.lastname) AS author_name FROM books JOIN categories ON books.category_id = categories.id
    JOIN authors ON books.author_id = authors.id WHERE books.id = :id;';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $book_id, PDO::PARAM_INT);
    $stmt->execute();

    $book = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Ako ne postoi UserId vrati nazad na index.php
}
$sql = 'SELECT * FROM comments WHERE book_id = :book_id AND deleted_at IS NULL';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$user_comments = [];
if (isset($_SESSION['user_id'])) {
    $sql = 'SELECT * FROM comments WHERE book_id = :book_id AND user_id = :user_id AND deleted_at IS NULL';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $user_comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$user_notes = [];
if (isset($_SESSION['user_id'])) {
    $sql = 'SELECT id, note FROM notes WHERE book_id = :book_id AND user_id = :user_id AND deleted_at IS NULL';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $user_notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $book['title'] ?></title>
    <meta charset="utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <!-- Local CSS -->
    <link rel="stylesheet" href="../css/style.css" />
    <!-- Latest compiled and minified Bootstrap 4.4.1 CSS -->
    <link rel="stylesheet" href="../css/assets/bootstrap.min.css" />
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- custom font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <!-- Latest Font-Awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/3b2a155ba0.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg--nav px-5 position-fixed w-100">
            <div class="container">
                <a class="navbar-brand flex mx-lg-auto" href="../index.php"><img src="../images/Logo.png" alt="logo image" class="logo d-block mx-auto mb-1">
                    <p class="mb-0 font-weight-bold text-uppercase h6">brainster</p>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class=" mr-auto"></div>
                    <div class="form-inline my-2 my-lg-0">
                        <ul class="navbar-nav mr-auto text-center mx-auto">
                            <?php if (isset($_SESSION['is_admin'])) { ?>
                                <li class="nav-item mr-5">
                                    <a class="nav-link" href="../admin/dashboard.php">Dashboard</a>
                                </li>
                            <?php } ?>
                            <?php if (!isset($_SESSION['username'])) { ?>
                                <li class="nav-item nav--btn mr-2 mb-2 mb-md-0">
                                    <a class="nav-link" href="../login.php">Login</a>
                                </li>
                                <li class="nav-item nav--btn">
                                    <a class="nav-link" href="../register.php">Sign Up</a>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item nav--btn">
                                    <a class="nav-link" href="../logout.php">Sign out</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="container">
        <div id="bg--book" class="row text-center mb-3">
            <div id="img" class="col-3">
                <img class="rounded" src="<?= $book['img_url'] ?>" alt="image">
            </div>
            <div class="col-6 px-5">
                <div class="text-left mb-5">
                    <h2 class=""><?= $book['title'] ?></h2>
                    <h5 class="text-muted"><?= $book['author_name'] ?></h5>
                </div>
                <div class="row text-center">
                    <p class="mr-3"><b>Pages</b>: <?= $book['pages'] ?></p>
                    <p class="mr-3"><b>Year</b>: <?= $book['year_published'] ?></p>
                    <p><b>Category</b>: <?= $book['category_title'] ?></p>
                </div>
            </div>
            <div class="col-3 text-right">
                <a href="#">
                    <i class="fa-regular fa-heart fa-2x text-dark"></i>
                </a>
            </div>
        </div>
        <div>

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-comments-tab" data-toggle="tab" data-target="#nav-comments" type="button" role="tab" aria-controls="nav-comments" aria-selected="true">Comments</button>
                    <button class="nav-link" id="nav-notes-tab" data-toggle="tab" data-target="#nav-notes" type="button" role="tab" aria-controls="nav-notes" aria-selected="false">Notes</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-comments" role="tabpanel" aria-labelledby="nav-comments-tab">
                    <div class="row">
                        <div class="col">
                            <ul class="mt-2 list-unstyled">
                                <?php foreach ($comments as $comment) : ?>
                                    <?php
                                    if ($comment['status'] == 1 || (isset($_SESSION['user_id']) && $comment['user_id'] == $_SESSION['user_id'])) {
                                    ?>
                                        <li>
                                            <?= $comment['comment'] ?>

                                            <?php if (isset($_SESSION['user_id']) && $comment['user_id'] == $_SESSION['user_id']) : ?>
                                                <form class="d-inline-block text-right" action="./destroy.php" method="POST">
                                                    <input type="hidden" value="<?= $comment['id'] ?>" name="id">
                                                    <button type="submit" class="btn d-inline-block" onclick="return confirm('Are you sure you want to delete the comment?')">
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <hr>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                <?php endforeach; ?>
                            </ul>
                            <?php if (isset($_SESSION['user_id']) && !count($user_comments)) : ?>
                                <form action="update.php" method="POST">
                                    <textarea required name="comment_text" id="comment" placeholder="Write your comment" class="form-control"></textarea>
                                    <input type="hidden" name="book_id" value="<?= $book_id ?>">
                                    <button type="submit" class="btn btn-primary mt-2">Add Comment</button>
                                </form>
                            <?php endif; ?>
                            <?php if (!empty($_SESSION['errors']['comment_text'])) : ?>
                                <p style="color: red"><?= $_SESSION['errors']['comment_text'] ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
                    <div class="row">
                        <div class="col">
                            <ul class="mt-2 list-unstyled" id="user_notes">
                                <?php if (isset($_SESSION['user_id']) && count($user_notes)) : ?>
                                    <?php foreach ($user_notes as $note) : ?>
                                        <li>
                                            <?= $note['note'] ?>
                                            <button class="btn d-inline-block" onclick="showUpdateNoteForm(<?= $note['id'] ?>, '<?= $note['note'] ?>')">
                                                <i class="fas fa-pen text-info"></i>
                                            </button>
                                            <button class="btn d-inline-block" onclick="removeNote(<?= $note['id'] ?>)">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                            <hr>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <div class="row" id="create_form">
                            <div class="col mt-3">
                                <textarea class="form-control" name="note" id="note" placeholder="Write your note"></textarea>
                                <button type="button" id="create_note" class="btn btn-primary mt-2">Add Note</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <div class="row" id="update_form" style="display: none;">
                            <div class="col mt-3">
                                <textarea class="form-control" name="note" id="updated_note" placeholder="Write your note"></textarea>
                                <input type="hidden" value="" id="updated_note_id">
                                <button type="button" id="update_note" onclick="updateNote()" class="btn btn-info mt-2">Update Note</button>
                                <button type="button" onclick="cancelUpdate()" class="btn btn-danger mt-2">Cancel</button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <footer class="text-center fixed-bottom py-3 bg-info">
        <div class="container">
            <p id="content" class="m-0 font-italic text-right">&nbsp;</p>
            <p class="mb-1 text-right">
                <span class="font-italic font-weight-bolder text-dark blockquote-footer" id="author-name">&nbsp;</span>
            </p>
        </div>
    </footer>

    <script src="../js/footer.js"></script>
    <!-- jQuery library -->
    <script src="../js/jquery-3.5.1.min.js"></script>
    <!-- Latest Compiled Bootstrap 4.4.1 JavaScript -->
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
        $("#create_note").click(function() {
            let note = $("#note");

            if (note.val().length < 10) {
                alert("Note must be at least 10 characters long.");
                return;
            }

            $.ajax({
                method: "POST",
                url: "./notes/store.php",
                dataType: "JSON",
                data: {
                    book_id: <?= $book_id ?>,
                    note: note.val()
                },
                success: function(response) {
                    showNotesToUser(response)
                    note.val('')
                }
            });
        });
        die();

        $("#create_note").click(function() {
            let note = $("#note")
            $.ajax({
                method: "POST",
                url: "./notes/store.php",
                dataType: "JSON",
                data: {
                    book_id: <?= $book_id ?>,
                    note: note.val()
                },
                success: function(response) {
                    showNotesToUser(response)
                    note.val('')
                }
            });
        });

        $(".remove-note").on('click', function(e) {
            let note_id = $(this).attr('data-note-id');
            console.log(note_id)
        })

        function removeNote(note) {
            if (confirm("Are you sure you want to delete the note?")) {
                $.ajax({
                    method: "POST",
                    url: "./notes/destroy.php",
                    dataType: "JSON",
                    data: {
                        book_id: <?= $book_id ?>,
                        note_id: note
                    },
                    success: function(response) {
                        showNotesToUser(response)
                    }
                });
            }
        }

        function showUpdateNoteForm(note_id, note_text) {
            let create_form = $("#create_form")
            let update_form = $("#update_form")

            $("#updated_note").val(note_text)
            $("#updated_note_id").val(note_id)

            create_form.hide()
            update_form.show()
        }

        function updateNote() {
            let note = $("#updated_note")
            let id = $("#updated_note_id")

            $.ajax({
                method: "POST",
                url: "./notes/update.php",
                dataType: "JSON",
                data: {
                    book_id: <?= $book_id ?>,
                    note_id: id.val(),
                    note: note.val()
                },
                success: function(response) {
                    cancelUpdate()
                    showNotesToUser(response)
                }
            });
        }


        function cancelUpdate() {
            $("#updated_note").val('')
            $("#updated_note_id").val('')

            $("#create_form").show()
            $("#update_form").hide()
        }

        function showNotesToUser(notes) {
            let notes_html = ""
            notes.forEach(note => {
                notes_html += `
                <li>
                    ${note.note}
                    <button class="btn d-inline-block" onclick="showUpdateNoteForm(${note.id}, '${note.note}')">
                        <i class="fas fa-pen text-info"></i>
                    </button>
                    <button class="btn d-inline-block" onclick="removeNote(${note.id})">
                        <i class="fas fa-trash text-danger"></i>
                    </button>
                </li>
                <hr>`
            })

            $("#user_notes").html(notes_html)
        }
    </script>
</body>

</html>