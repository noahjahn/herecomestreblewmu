<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
    <?php $this->load->view('require/head'); ?>
    <body>
        <a name="home" ></a>
        <?php $this->load->view('require/nav'); ?>
        <script>
        function redirect_to_edit() {
            var url = "<?php echo base_url() ?>profile/add";
            console.log(url);
            window.location.replace(url);
        }
        </script>
        <?php
        if ($this->session->userdata('username') == FALSE) {
            $this->load->view('errors/no_access');
        } else {
            $username = $this->session->userdata('username');

            $this->db->where('bios.username', $username);
            $this->db->join('users', 'bios.username = users.username');
            $query = $this->db->get('bios');

            foreach ($query->result() as $row)
            {
                echo '<h1 class="mt-5, ml-5">Welcome to your profile, ' . $row->firstname . ' ' . $row->lastname . '</h1>';
            }
        }
        ?>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <h3>Your Bio:</h3>
                <div class="row">
                    <div class="col-7">
                        <div class="new_card">
                            <?php
                                $this->db->where('bios.username', $username);
                                $this->db->join('users', 'bios.username = users.username');
                                $query = $this->db->get('bios');

                                foreach ($query->result() as $row) {
                                    echo '<img src="' . base_url() . $row->image . '" alt="" style="width:100%;">';
                                    echo '<div class="container">';
                                    echo '<h2>'. $row->firstname . ' ' . $row->lastname . '</h2>';
                                    if ($row->position !== NULL) {
                                        echo '<p class="title">' . $row->position . '</p>';
                                    }
                                    echo '<p class="title">' . $row->classification . '</p>';
                                    echo '<p class="title">' . $row->major . '</p>';
                                    echo '<p>' . $row->description . '</p>';
                                    echo '</div>';
                                }
                             ?>

                        </div>
                    </div>
                </div>
                <br><br>
                <button onclick="redirect_to_edit()" type="button" class="btn btn-secondary ml-2">Edit</button>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <h3>Your posts:</h3>
                    <table class="table table-hover">
                        <tr class="table-info">
                            <th>Title</th>
                            <th>Post Date</th>
                            <th>Likes</th>
                            <th>Dislikes</th>
                        </tr>
                        <?php
                            $username = $this->session->userdata('username');
                            $this->db->where('post_author', $username);
                            $query = $this->db->get('gallery');

                            $i = 0;
                            foreach ($query->result() as $row)
                            {
                                if ($i % 2 == 0) {
                                    echo '<tr class="table-primary"><td>' . $row->post_title . '</td><td>' . $row->post_date . '</td><td>' . $row->post_likes . '</td><td>' . $row->post_dislikes . '</td>';
                                } else {
                                    echo '<tr class="table-light"><td>' . $row->post_title . '</td><td>' . $row->post_date . '</td><td>' . $row->post_likes . '</td><td>' . $row->post_dislikes . '</td>';
                                }
                            $i++;
                            }
                         ?>
                    </table>
                </div>
                <div class="row">
                    <h3> Your favorites:</h3>
                    <table class="table table-hover">
                        <tr class="table-info">
                            <th>Title</th>
                            <th>Post Date</th>
                            <th>Likes</th>
                            <th>Dislikes</th>
                        </tr>
                        <?php
                            $username = $this->session->userdata('username');
                            $this->db->where('username', $username);
                            $this->db->join('user_favorites', 'user_favorites.uid = users.id');
                            $this->db->join('gallery', 'gallery.gid = user_favorites.gid');
                            $query = $this->db->get('users');

                            $i = 0;
                            foreach ($query->result() as $row)
                            {
                                if ($i % 2 == 0) {
                                    echo '<tr class="table-primary"><td>' . $row->post_title . '</td><td>' . $row->post_date . '</td><td>' . $row->post_likes . '</td><td>' . $row->post_dislikes . '</td>';
                                } else {
                                    echo '<tr class="table-light"><td>' . $row->post_title . '</td><td>' . $row->post_date . '</td><td>' . $row->post_likes . '</td><td>' . $row->post_dislikes . '</td>';
                                }
                            $i++;
                            }
                         ?>
                    </table>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php $this->load->view('require/footer.php'); ?>
    </body>
</html>
