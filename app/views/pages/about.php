<?php require "../app/views/layouts/header.php"; ?>

<div class="aboutStore">

    <!-- HERO / EDITORIAL -->
    <section class="aboutStore-hero">
        <div class="aboutStore-heroInner">
            <div class="aboutStore-heroCopy">
                <span class="aboutStore-kicker">XARÈA • SHOES & CLOTHING</span>
                <h1>Made for daily wear.</h1>
                <p>
                    We curate shoes and clothes that feel good, look clean, and work with your everyday life.
                    Simple fits. Easy styling. No overthinking.
                </p>
                <div class="aboutStore-actions">
                    <a class="storeBtn solid" href="?page=category&cat=clothes&gen=women">Shop Clothing</a>
                    <a class="storeBtn ghost" href="?page=category&cat=shoes&gen=women">Shop Shoes</a>
                </div>
            </div>

            <div class="aboutStore-heroMedia">
                <!-- Replace with any nice fashion photo -->
                <img src="/store-system/public/images/about/first.jpeg" alt="XARÈA lookbook">
            </div>
        </div>
    </section>

    <!-- BRAND STORY -->
    <section class="aboutStore-section">
        <div class="aboutStore-wrap">
            <div class="aboutStore-split">
                <div>
                    <h2>The Brand</h2>
                    <p>
                        XARÈA is built around pieces you can repeat.
                        A great sneaker. A clean hoodie. A jacket that works with everything.
                    </p>
                    <p>
                        We focus on wearable style — for women, men, and kids — with drops that stay current
                        without chasing trends too hard.
                    </p>
                </div>

                <div class="aboutStore-note">
                    <h3>What you’ll find here</h3>
                    <ul>
                        <li>Everyday sneakers & comfortable shoes</li>
                        <li>Clean basics, streetwear, seasonal layers</li>
                        <li>Honest offers + new arrivals</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- LOOKBOOK GRID -->
    <section class="aboutStore-section alt">
        <div class="aboutStore-wrap">
            <div class="aboutStore-head">
                <h2>Lookbook</h2>
                <p>Real outfits, clean styling.</p>
            </div>

            <div class="aboutStore-grid">
                <a class="gItem tall" href="?page=category&cat=clothes&gen=women">
                    <img src="/store-system/public/images/about/look1.jpeg" alt="Look 1">
                    <span>Women</span>
                </a>
                <a class="gItem" href="?page=category&cat=shoes&gen=men">
                    <img src="/store-system/public/images/about/look2.jpeg" alt="Look 2">
                    <span>Men shoes</span>
                </a>
                <a class="gItem" href="?page=category&cat=clothes&gen=men">
                    <img src="/store-system/public/images/about/look3.jpeg " alt="Look 3">
                    <span>Men</span>
                </a>
                <a class="gItem" href="?page=category&cat=shoes&gen=women">
                    <img src="/store-system/public/images/about/look4.jpeg" alt="Look 4">
                    <span>Women shoes</span>
                </a>
                <a class="gItem" href="?page=category&cat=clothes&gen=kids">
                    <img src="/store-system/public/images/about/look5.jpeg" alt="Look 5">
                    <span>Kids</span>
                </a>
            </div>
        </div>
    </section>

    <!-- SERVICE STRIP -->
    <section class="aboutStore-section">
        <div class="aboutStore-wrap">
            <div class="aboutStore-service">
                <div class="serviceCard">
                    <div class="serviceTitle">Sizing help</div>
                    <div class="serviceText">Not sure? Contact us — we reply fast.</div>
                </div>
                <div class="serviceCard">
                    <div class="serviceTitle">Easy returns</div>
                    <div class="serviceText">Simple return process with clear steps.</div>
                </div>
                <div class="serviceCard">
                    <div class="serviceTitle">Fast checkout</div>
                    <div class="serviceText">Clean cart and smooth shopping flow.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- TEAM (5) -->
    <section class="aboutStore-section team">
        <div class="aboutStore-wrap">
            <div class="aboutStore-head">
                <h2>Meet our team</h2>
            </div>

            <div class="aboutStore-team">
                <div class="member">
                    <img src="/store-system/public/images/xhesi.jpeg" alt="Team member">
                    <h4>Xhesilda Hyka</h4>
                    <span>Founder</span>
                    <p>Keeps the brand clean and the collections consistent.</p>
                </div>

                <div class="member">
                    <img src="/store-system/public/images/asja.jpeg" alt="Team member">
                    <h4>Asja Fjolla</h4>
                    <span>Clothing</span>
                    <p>Curates outfits and seasonal drops for everyday wear.</p>
                </div>

                <div class="member">
                    <img src="/store-system/public/images/ersa.jpeg" alt="Team member">
                    <h4>Ersa Zani</h4>
                    <span>Shoes</span>
                    <p>Handles sneakers, comfort picks, and best sellers.</p>
                </div>

                <div class="member">
                    <img src="/store-system/public/images/ariel.jpeg" alt="Team member">
                    <h4>Ariel Mehmetaj</h4>
                    <span>Customer care</span>
                    <p>Answers messages and helps with orders & sizing.</p>
                </div>

                <div class="member">
                    <img src="/store-system/public/images/redi.jpeg" alt="Team member">
                    <h4>Redi Mema</h4>
                    <span>Quality</span>
                    <p>Checks details so everything stays smooth and clean.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SIMPLE CTA -->
    <section class="aboutStore-cta">
        <div class="aboutStore-wrap ctaInner">
            <div>
                <h3>Questions about sizing or an order?</h3>
                <p>Send us a message — we’ll help you quickly.</p>
            </div>
            <div class="ctaBtns">
                <a class="storeBtn ghost" href="?page=contact">Contact</a>
                <a class="storeBtn solid" href="?page=home">Back to Home</a>
            </div>
        </div>
    </section>

</div>

<?php require "../app/views/layouts/footer.php"; ?>
