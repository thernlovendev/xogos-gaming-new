<div class="col-lg-4">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Highest Progess</h5>
                <h3 class="card-title"><i class="tim-icons icon-bullet-list-67 text-success"></i> Top Players</h3>
              </div>
              <div class="card-body">
                <div class="chart-area">
                <table class="table">
                <thead class="text-primary">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $query = "SELECT * FROM users WHERE user_role = 'student' ORDER BY total_coins DESC";
                        $result = mysqli_query($connection, $query);

                        $counter = 1; // Counter variable to track the rank

                        while ($row = mysqli_fetch_assoc($result)) {
                            $rank = $counter;
                            $firstname = $row['firstname'];
                            $lastname = $row['lastname'];
                            $total_coins = $row['total_coins'];

                            echo "<tr>";
                            echo "<td>" . $rank . "</td>"; // Echo the counter value as the user_id
                            echo "<td>" . $firstname . " " . $lastname . "</td>";
                            echo "</tr>";

                            $counter++; // Increment the counter for the next iteration
                        }
                        ?>

                   </tbody>
</table>
                </div>
              </div>
            </div>
          </div>