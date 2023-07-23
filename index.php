<?php 
require_once 'Database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Machine Test - Narayan Zade</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'></link>  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
  #bodybg{
    background-image: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSojK3NOSSdalPNrDLdppgyqjeP2QVw6P9mqHBLr-juiWaBV9ET5n8DSZny79yUvzZcQ0c&usqp=CAU");
    background-size: cover;
    background-repeat: no-repeat;
    width: 100%;
    font-family: monospace;
    font-weight: 700;
  }
  </style>
<body id="bodybg">

<div class="container-fluid p-5  text-black text-center">
  <h1>Self Referencing Foreign key for Same Table - Implemented </h1>
 
</div>
  
<div class="container">
  
  <div class="row">
    <div class="col-md-12">
   
    <div id="refreshtree">
        <?php
        $db = new Database();
        $connected = $db->Connection();
        $query = "SELECT id, name, parentid FROM members";
        $result = $connected->query($query);
        
        // Fetch data as an associative array
        $members = $result->fetchAll(PDO::FETCH_ASSOC);

        function MakeTree($members, $parentID = null) {
            $tree = array();
    
            foreach ($members as $member) {
                if ($member['parentid'] == $parentID) {
                    $children = MakeTree($members, $member['id']);
                    if (!empty($children)) {
                        $member['children'] = $children;
                    }
                    $tree[] = $member;
                }
            }
    
            return $tree;
        }
        $membersHierarchy = MakeTree($members);
        
        // Generate the HTML tree
        function HTMLTree($tree) {
            echo '<ul>';
            foreach ($tree as $node) {
                echo '<li>' . $node['name'];
    
                if (isset($node['children'])) {
                    HTMLTree($node['children']); // Recursively call itself to generate HTML for children 
                }
    
                echo '</li>';
            }
            echo '</ul>';
        }
    
        // Call the function onload
        HTMLTree($membersHierarchy);
        ?>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addmember" >Add New Member</button>
    </div>
</div>

<div class="modal fade" id="addmember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form id="addmemberform">
    <div class="modal-content" style="margin-top: 200px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Enter Member Details</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
        <div id="refreshlist">
            <label for="formGroupExampleInput">Parent</label>
            <select  id="parentid" name="parentid" class="form-select">
            <option value="" disabled selected>Choose Parent</option>
            <?php
            foreach($members as $member){ ?>

            <option value="<?php echo $member['id'];?>"><?php echo $member['name'];?></option>

            <?php } ?>
            </select>
         </div>
        </div>
        <div class="form-group">
        <label for="formGroupExampleInput">Name</label>
        <input type="text" class="form-control" id="name" name="name" pattern="^[A-Za-z\s]*$" title=" Characters and spaces only accepted" placeholder="Enter Name" required>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>

    </div>
</form>
  </div>
</div>

<script>
    // ajax to save new member
        $(document).ready(function() {
            $("#addmemberform").submit(function(event) {
                event.preventDefault(); //prevent form submission
      
                // Get form data
                var formData = $(this).serialize();
                
                // AJAX request to insert the member
                $.ajax({
                    url: "MemberCtrl.php",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $("#name").val("");
                        $('#addmember').modal('hide'); // hide model after operation done
                        $("#refreshlist").load(location.href + " #refreshlist"); // refresh parent list in model 
                        $("#refreshtree").load(location.href + " #refreshtree"); // refresh tree 
                    },
                    error: function() {
                       swal('Someting wrong , Contact Narayan Zade',"Won’t take too long, just 2 billion hours.", "error")
                    }
                });
               
            });
        });
    </script>
</body>
</html>

