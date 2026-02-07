<?php require "../app/views/layouts/header.php"; ?>

<?php if (!empty($_SESSION['contact_success'])): ?>
    <div style="max-width:1200px;margin:20px auto;padding:14px;background:#f6f2ea;border-radius:12px;font-weight:600;">
        <?= htmlspecialchars($_SESSION['contact_success']) ?>
    </div>
    <?php unset($_SESSION['contact_success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['contact_error'])): ?>
    <div style="max-width:1200px;margin:20px auto;padding:14px;background:#ffe6e6;border-radius:12px;font-weight:600;">
        <?= htmlspecialchars($_SESSION['contact_error']) ?>
    </div>
    <?php unset($_SESSION['contact_error']); ?>
<?php endif; ?>


<style>
    /* contact style */

    .contactStore { font-family: 'Poppins', sans-serif; color:#111; }

    /* HERO */
    .contactStore-hero{
        background: linear-gradient(135deg, #f6f2ea 0%, #ffffff 70%);
        padding: 70px 20px;
        border-bottom: 1px solid rgba(0,0,0,.06);
    }
    .contactStore-wrap{ max-width: 1200px; margin:auto; }

    .contact-kicker{
        display:inline-flex;
        align-items:center;
        gap:10px;
        letter-spacing: .18em;
        font-size: 12px;
        color: rgba(0,0,0,.55);
        font-weight: 700;
        text-transform: uppercase;
    }
    .kicker-dot{
        width:8px;height:8px;border-radius:50%;
        background:#111; opacity:.25;
    }

    .heroCopy h1{
        margin: 16px 0 10px;
        font-size: 44px;
        letter-spacing: -0.02em;
    }
    .heroCopy p{
        color: rgba(0,0,0,.65);
        font-size: 15px;
        max-width: 560px;
        line-height: 1.9;
    }

    /* HERO GRID (added image on right) */
    .heroGrid{
        display:grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 30px;
        align-items:center;
    }
    .heroImage{
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(0,0,0,.18);
        min-height: 300px;
    }
    .heroImage img{
        width:100%;
        height:100%;
        object-fit: cover;
        display:block;
    }

    /* SECTION */
    .contactStore-section{
        padding: 70px 20px 30px;
        background:#fff;
    }

    .contactGrid{
        display:grid;
        grid-template-columns: 1.2fr .8fr;
        gap: 18px;
        align-items:start;
    }

    /* CARDS */
    .contactCard{
        background:#fff;
        border-radius: 20px;
        border:1px solid rgba(0,0,0,.08);
        box-shadow: 0 18px 45px rgba(0,0,0,.08);
        padding: 24px;
    }
    .contactCard h2{
        font-size: 22px;
        margin-bottom: 14px;
    }
    .contactCard h3{
        margin-bottom: 10px;
        font-size: 18px;
    }

    /* FORM */
    .contactForm{
        display:flex;
        flex-direction: column;
        gap: 12px;
    }

    .fieldRow{
        display:grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .contactForm input,
    .contactForm textarea{
        width: 100%;
        padding: 12px 3px;
        border-radius: 14px;
        border:1px solid rgba(0,0,0,.15);
        font-family: inherit;
        font-size: 14px;
        background: #fff;
    }

    .contactForm input:focus,
    .contactForm textarea:focus{
        outline:none;
        border-color:#111;
        box-shadow: 0 0 0 4px rgba(0,0,0,.06);
    }

    /* Buttons */
    .storeBtn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:10px;
        padding: 12px 16px;
        border-radius: 14px;
        font-weight: 800;
        font-size: 14px;
        cursor: pointer;
        border: 1px solid rgba(0,0,0,.14);
        transition: transform .15s ease, box-shadow .15s ease, background .15s ease;
        text-decoration:none;
    }
    .storeBtn:hover{ transform: translateY(-1px); box-shadow: 0 16px 34px rgba(0,0,0,.10); }
    .storeBtn.solid{
        background:#111;
        color:#fff;
        border-color:#111;
    }
    .storeBtn.solid:hover{ background:#000; }
    .storeBtn.ghost{
        background:#fff;
        color:#111;
    }
    .storeBtn.ghost:hover{ background:#f6f2ea; }

    /* INFO */
    .infoCard p{
        color: rgba(0,0,0,.65);
        line-height: 1.9;
        font-size: 14px;
    }

    .infoList{
        margin-top: 14px;
        display:flex;
        flex-direction: column;
        gap: 12px;
    }

    .infoList span{
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .08em;
        color: rgba(0,0,0,.45);
        text-transform: uppercase;
    }

    .infoNote{
        margin-top: 18px;
        padding: 14px;
        background:#f6f2ea;
        border-radius: 14px;
        font-size: 13px;
        color: rgba(0,0,0,.7);
        border: 1px solid rgba(0,0,0,.06);
    }

    /* MAP SECTION */
    .contactMap{
        padding: 40px 20px 85px;
        background: #fff;
    }
    .mapCard{
        max-width: 1200px;
        margin: auto;
        border-radius: 22px;
        overflow:hidden;
        border:1px solid rgba(0,0,0,.08);
        box-shadow: 0 18px 45px rgba(0,0,0,.08);
        background: linear-gradient(135deg, #ffffff 0%, #f6f2ea 100%);
    }
    .mapTop{
        padding: 22px 24px;
        display:flex;
        justify-content: space-between;
        gap: 16px;
        align-items:flex-start;
    }
    .mapTop h2{
        margin: 0 0 8px;
        font-size: 20px;
    }
    .mapTop p{
        margin:0;
        color: rgba(0,0,0,.65);
        line-height:1.8;
        font-size:14px;
        max-width: 700px;
    }
    .mapBtns{
        display:flex;
        gap: 10px;
        flex-wrap:wrap;
    }
    .mapFrame{
        width:100%;
        height: 420px;
        background:#ddd;
    }
    .mapFrame iframe{
        width:100%;
        height:100%;
        border:0;
        filter: saturate(1.05) contrast(1.05);
    }

    /* RESPONSIVE */
    @media (max-width: 900px){
        .contactGrid{ grid-template-columns: 1fr; }
        .mapTop{ flex-direction: column; }
        .heroGrid{ grid-template-columns: 1fr; }
        .heroImage{ max-height: 320px; }
    }
    @media (max-width: 500px){
        .fieldRow{ grid-template-columns: 1fr; }
        .heroCopy h1{ font-size: 34px; }
    }
</style>

<div class="contactStore" id="top">

    <!-- HERO -->
    <section class="contactStore-hero">
        <div class="contactStore-wrap heroInner heroGrid">

            <div class="heroCopy">
                <span class="contact-kicker">
                    CONTACT • XARÈA <span class="kicker-dot"></span> SUPPORT
                </span>
                <h1>We’re here to help.</h1>
                <p>
                    Questions about sizing, orders, or availability?
                    Send us a message — we reply quickly.
                </p>
            </div>

            <!-- HERO IMAGE (add your photo here) -->
            <div class="heroImage">
                <img src="/store-system/public/images/contact.jpg" alt="XARÈA fashion store">
            </div>

        </div>
    </section>

    <!-- CONTENT -->
    <section class="contactStore-section">
        <div class="contactStore-wrap contactGrid">
            <div>
                <!-- FORM -->
                <div class="contactCard formCard">
                    <h2>Send us a message</h2>

                    <form method="POST" action="?page=contact-send" class="contactForm">

                        <div class="fieldRow">
                            <input type="text" name="name" placeholder="Your name" required>
                            <input type="email" name="email" placeholder="Email address" required>
                        </div>

                        <input type="text" name="subject" placeholder="Subject" required>

                        <textarea name="message" rows="5" placeholder="Write your message..." required></textarea>

                        <button type="submit" class="storeBtn solid">Send message</button>
                    </form>
                </div>
                <div class="infoNote">
                    We focus on wearable style and smooth service —
                    if something feels off, let us know.
                </div>
            </div>
            <!-- INFO -->
            <div class="contactCard infoCard">
                <h3>Customer support</h3>

                <p>
                    We usually respond within <strong>24 hours</strong>.
                    For urgent questions, include your order number.
                </p>

                <div style="margin-top:14px;">
                    <a class="storeBtn ghost" href="mailto:xhesildahyka6@gmail.com">Email us</a>
                </div>

                <div class="infoList">
                    <div>
                        <span>Email</span>
                        <p>xhesildahyka6@gmail.com</p>
                    </div>
                    <div>
                        <span>Store hours</span>
                        <p>Mon – Fri, 09:00 – 21:00</p>
                    </div>
                    <div>
                        <span>Location</span>
                        <p>Tirana, Albania</p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- MAP SECTION -->
    <section class="contactMap">
        <div class="mapCard">
            <div class="mapTop">
                <div>
                    <h2>Visit our store</h2>
                    <p>
                        Find us near <strong>Universiteti Metropolitan Tirana</strong>.
                        Stop by anytime during working hours — or contact us online.
                    </p>
                </div>

                <div class="mapBtns">
                    <a class="storeBtn solid"
                       target="_blank"
                       href="https://www.google.com/maps/search/?api=1&query=Universiteti+Metropolitan+Tirana">
                       📍 Get Directions
                    </a>
                    <a class="storeBtn ghost" href="#top">⬆ Back to top</a>
                </div>
            </div>

            <div class="mapFrame">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2996.4815394449747!2d19.827436075914857!3d41.320141171308435!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x13503103baf4d8a7%3A0x6e0183d08de9263c!2sUniversiteti%20Metropolitan%20Tirana!5e0!3m2!1sen!2s!4v1770414788905!5m2!1sen!2s"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </section>

</div>

<?php require "../app/views/layouts/footer.php"; ?>
