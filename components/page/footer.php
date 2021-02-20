<?php 
if(!defined("root")){
    header("location:../index.php");die;
}
 ?>

<footer>
        <div class="footer-body row px-1 py-4 px-lg-5 py-lg-5">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-12  pb-2">
                        <h5 class="title">HNF CINEPLEX</h5>
                    </div>
                    <div class="col-12  ">
                        <small class="text-white-50">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ullam, magni ratione error, odit quis non fugit laboriosam minus atque consequatur reprehenderit architecto ut illum, in minima itaque hic? Quam dolorum distinctio minima ipsam, iusto officia tenetur sunt omnis hic quaerat unde corporis neque pariatur iure quae aspernatur perferendis fugiat accusantium nihil ullam? Possimus, quo soluta. Quae amet assumenda autem. Eaque suscipit tempore neque necessitatibus earum! Nulla, quo officia! Vel temporibus necessitatibus distinctio dolores consequatur esse molestiae soluta iure ullam. Officiis soluta quisquam modi perferendis porro qui eos, similique repellendus neque quam eligendi amet iste! Veniam sequi labore expedita accusantium velit?</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center mt-4 pt-3 mt-lg-0 pt-lg-0">
                <div class="row  pb-2 ">
                    <div class="col-6">
                        Page
                        <ul>
                            <li><a href="<?= BASEURL; ?>" >Home</a></li>
                            <li><a href="<?= BASEURL."page/listfilm.php?st=nowplaying"; ?>">Now Playing</a></li>
                            <li><a href="<?= BASEURL."page/listfilm.php?st=upcoming"; ?>">Upcoming</a></li>
                            <li><a href="<?= BASEURL."page/login.php"; ?>">Log in</a></li>
                            <li><a href="<?= BASEURL."page/register.php"; ?>">Sign Up</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        Company
                        <ul>
                            <li><a href="<?= BASEURL."page/about.php"; ?>">About Us</a></li>
                            <li><a href="<?= BASEURL."page/contact.php"; ?>">Contact Us</a></li>
                            <li><a href="https://radhikaproduction.netlify.app/">Developer</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row " >
                    <div class="col">
                        <div class="footer-items pt-4"> To get the latest update </div>
                        <div class="footer-items follow-us mx-auto">FOLLOW US</div>
                        <div class="footer-items sosmed-icon">
                            <a href=""><i class="fab fa-facebook-square"></i></a>
                            <a href=""><i class="fab fa-twitter"></i></a>
                            <a href=""><i class="fab fa-instagram"></i></a>
                            <a href=""><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy-right text-center"> © 2020-2021 RadhikaProduction • All rights reserved</div>
</footer> 