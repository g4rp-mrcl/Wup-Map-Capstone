<style>
.card {
    /* Add shadows to create the "card" effect */
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    background:  #F6F5B2;
  }
  
  /* On mouse-over, add a deeper shadow */
  .card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
  }
  
  /* Add some padding inside the card container */
  .container {
    padding: 2px 16px;
  }
</style>

<div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach (json_decode($announcements) as $announcement)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ $announcement->name }}
                        </h5>
                        <p class="card-text">
                            {{ $announcement->description }}
                        </p>
                        <a href="#" class="btn btn-warning">Read More</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
