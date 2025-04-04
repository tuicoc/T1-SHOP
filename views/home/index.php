<?php
require_once '../config/config.php';
include APP_ROOT . '/views/shared/header.php';
?>

<main style="text-align: center;">


    <div class="title-container" style="margin-top: 0px;">
        <h2 class="title-back">COLLECTION</h2>
        <h2 class="title-front">COLLECTION</h2>
    </div>
    <div class="collection">
        <div class="item">
            <img src="../public/images/collection2024LOL.jpg" alt="Team Kit">
            <div class="overlay">
                <h3>2024 LOL Team</h3>
                <p>2024 Offical Collection</p>
                <a href="/mywebsite/public/index.php?controller=categories&category=0">BUY NOW →</a>
            </div>
        </div>
        <div class="item">
            <img src="../public/images/pic1.png" alt="Basic">
            <div class="overlay">
                <h3>2025 LOL Team</h3>
                <p>2025 Offical Collection</p>
                <a href="/mywebsite/public/index.php?controller=categories&category=0">BUY NOW →</a>
            </div>
        </div>
        <div class="item">
            <img src="../public/images/pic4.jpg" alt="Players">
            <div class="overlay">
                <h3>2024 Valorant Team</h3>
                <p>2024 Offical Collection</p>
                <a href="/mywebsite/public/index.php?controller=categories&category=1">BUY NOW →</a>
            </div>
        </div>
        <div class="item">
            <img src="../public/images/Collection2025Val.png" alt="Collaboration">
            <div class="overlay">
                <h3>2025 Valorant Team</h3>
                <p>2025 Offical Collection</p>
                <a href="/mywebsite/public/index.php?controller=categories&category=1">BUY NOW →</a>
            </div>
        </div>
    </div>

  <!-- Title 2 -->

  <div class="title-container">
        <h2 class="title-back handleTitleResposne">T1 OFFICIAL</h2>
        <h2 class="title-front">T1 OFFICIAL</h2>
    </div>

  <!-- New Collection -->
  <div class="collection-2">
      <div class="collection-item large">
          <img src="../public/images/dashboardPicture.jpg" alt="T1 2025 Official Uniform">
          <div class="collection-text">
              <h3 class="whiteText">T1 2025 <br> <span class="bold whiteText">OFFICIAL UNIFORM</span></h3>
              <p class="whiteText">T1 유니폼을 입고 우승을 응원해주세요!</p>
              <a href="#" class="buy-now">BUY NOW →</a>
          </div>
      </div>
      <div class="collection-item">
          <img src="../public/images/pic1.png" alt="T1 Uniform Jacket">
          <div class="product-info">
              <p class="product-name">[LoL] 2025 T1 Uniform Jacket</p>
              <p class="product-price">149,000원</p>
          </div>
      </div>
      <div class="collection-item">
          <img src="../public/images/pic1.png" alt="T1 DIY Marking Kit">
          <div class="product-info">
              <p class="product-name">[LoL] 2025 T1 DIY Marking Kit</p>
              <p class="product-price">10,000원</p>
          </div>
      </div>
  </div>

    <!-- Community Section -->
    <h2 class="title-container handleCommunity">
          <span class="title-back">COMMUNITY</span>
          <span class="title-front">COMMUNITY</span>
      </h2>

  <div class="community-container">
      <div class="community-content">
          <a href="#" class="community-item">
              <img src="../public/images/event_menu.png" alt="Notice">
          </a>
          <a href="#" class="community-item">
              <img src="../public/images/notice_menu.png" alt="Event">
          </a>
      </div>
  </div>

  <!-- Review -->

  <div class="title-container">
        <h2 class="title-back">REVIEW</h2>
        <h2 class="title-front">REVIEW</h2>

        <div class="review-navigation">
            <button id="prevReview" class="nav-btn">&#10094;</button>
            <button id="nextReview" class="nav-btn">&#10095;</button>
        </div>
    </div>


  <section class="review-section">

            <div class="review-container">
                <div class="review-card">
                    <img src="../public/images/reviewPic1.jpg" alt="Product 1">
                    <div class="review-content">
                        <div class="stars">★★★★★</div>
                        <p class="review-text">Amazing quality, really love it!</p>
                        <p class="buyer">네이버 페이 구매자</p>
                        <p class="product-name">2025 T1 Uniform Jacket</p>
                        <p class="rating">Average rating 5.0 | Total sale 21</p>
                    </div>
                </div>

                <div class="review-card">
                    <img src="../public/images/reviewPic2.jpg" alt="Product 2">
                    <div class="review-content">
                        <div class="stars">★★★★★</div>
                        <p class="review-text">Absolutely love it</p>
                        <p class="buyer">네이버 페이 구매자</p>
                        <p class="product-name">T1 Logo Badge</p>
                        <p class="rating">Average rating 5.0 | Total sale 9</p>
                    </div>
                </div>

                <div class="review-card">
                    <img src="../public/images/reviewPic3.jpg" alt="Product 3">
                    <div class="review-content">
                        <div class="stars">★★★★★</div>
                        <p class="review-text">Best shirt ever!</p>
                        <p class="buyer">네이버 페이 구매자</p>
                        <p class="product-name">T1 Logo T-Shirt</p>
                        <p class="rating">Average rating 5.0 | Total sale 32</p>
                    </div>
                </div>

                <div class="review-card">
                    <img src="../public/images/reviewPic4.jpg" alt="Product 4">
                    <div class="review-content">
                        <div class="stars">★★★★☆</div>
                        <p class="review-text">A bit expensive</p>
                        <p class="buyer">네이버 페이 구매자</p>
                        <p class="product-name">2025 T1 DIY Marking Kit</p>
                        <p class="rating">Average rating 4.8 | Total sale 29</p>
                    </div>
                </div>

                <div class="review-card">
                    <img src="../public/images/reviewPic5.jpg" alt="Product 5">
                    <div class="review-content">
                        <div class="stars">★★★★★</div>
                        <p class="review-text">Perfect fit and design!</p>
                        <p class="buyer">네이버 페이 구매자</p>
                        <p class="product-name">T1 Strap Keychain - Red</p>
                        <p class="rating">Average rating 5.0 | Total sale 9</p>
                    </div>
                </div>
            </div>

        </section>


   

</main>

<?php
require_once '../config/config.php';
include APP_ROOT . '/views/shared/footer.php';
?>