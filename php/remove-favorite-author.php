<?php
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    # Database Connection File
    include "../db_conn.php";

    /**
     * Check if the author id is set
     **/
    if (isset($_GET['author_id'])) {
        /**
         * Get data from GET request and store it in variables
         **/
        $locate = isset($_GET['location']) ? $_GET['location'] : 'index';
        $id = $_GET['author_id'];

        # Simple form validation
        if (empty($id)) {
            $em = "Error Occurred!";
            header("Location: ../admin.php?error=$em");
            exit;
        } else {
            # DELETE the author from Database
            $sql = "DELETE FROM favorite_author WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$id]);

            /**
             * If there is no error while deleting the data
             **/
            if ($res) {
                # Success message
                $sm = "Removed From Your Favorites!";
                if ($locate == "index") {
                    header("Location: ../favorite.php?success=$sm");
                } else {
                    header("Location: ../author.php?success=$sm&id=$id");
                }
                exit;
            } else {
                $em = "Unknown Error Occurred!";
                if ($locate == "index") {
                    header("Location: ../favorite.php?error=$em");
                } else {
                    header("Location: ../author.php?error=$em&id=$id");
                }
                exit;
            }
        }
    } else {
        header("Location: ../admin.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
