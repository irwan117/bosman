<body>
  <!-- Flash Notification -->
  <div id="flashMessage" style="position: fixed; top: 10px; right: 10px; background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px; display: none;">
    Selamat Datang Admin
  </div>

  <section class="slider_section">
    <div id="customCarousel1" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <div class="detail-box">
                  <h1>
                    Bosman <br>
                    BarberShop
                  </h1>
                  <p>
                    Tempat Potong dan Perawatan Rambut Yang Murah Dan Terpercaya.
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="img-box">
                  <img src="assets/images/bosman1.png" alt="">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    // Display the flash message when the page loads
    window.onload = function() {
      var flashMessage = document.getElementById('flashMessage');
      flashMessage.style.display = 'block';

      // Hide the message after 3 seconds
      setTimeout(function() {
        flashMessage.style.display = 'none';
      }, 3000);
    };
  </script>
</body>
