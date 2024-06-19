<main>
    <div class="inner_container">
        <div class="register" >
            <form action = "scripts/register.php" method="post">
                <label for="email">Email</label>
                <input name="login" type="email" id="email" required>
                <label for="nickname">Nik</label>
                <input name="name" type="text" id="nickname" required>
                <label for="password">Password</label>
                <input name="password" type="password" id="password" required>
                <label class="sogl">
                    <input type = "checkbox" required>
                    <span>Я соглошаюсь ляля тополя</span>
                </label>
                <button class="registr">Зарегистрироваться</button>
            </form>
            <div class="switch">
                <p>Уже зарегистрированны?</p>
                <button id="switch_to_login">Войдите</button>
            </div>
        </div>
        <div class="login active" >
            <form action = "scripts/login.php" method="post">
                <label for="login_email">Email</label>
                <input name="login" type = "email" id="login_email">
                <label for="login_password">Password</label>
                <input name="password" type = "password" id="login_password">
                <button>Войти</button>
            </form>
            <div class="switch">
                <p>Еще нет аккаунта?</p>
                <button id="switch_to_register">Зарегистрируйся</button>
            </div>
        </div>
    </div>
</main>