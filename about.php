<?php

function showAboutContent() {
    echo   '<div class="content">
                <h1>About Me</h1>
                <div class="aboutme">
                    <img src="img/profile_picture.JPG" alt="A profile picture of me">
                    <p>I\'m an application/software development trainee. My ambition is to become a data engineer.</p>
                    <p>I\'m currently working at Educom, to get a solid foundation in programming.</p>
                    <p>I enjoy:
                        <ul>
                            <li>Exercising</li>
                            <li>Cooking</li>
                            <li>Reading</li>
                        </ul>
                    </p>
                    <button class="get_in_touch" type="button"><a href="index.php?page=contact">Contact Me</a></button>
                </div>
            </div>';
}