<h2>Регистрация нового пользователя в системе</h2>
<form id="login" class="login" action="/admin/create_user" method="POST">
	<div id="reg">
		<dl>
			<dd><span class="pole">Имя</span>
				<input type="text" name="first_name">
			</dd>
			<dd><span class="pole">Фамилия</span>
				<input type="text" name="last_name">
			</dd>
		</dl>
		<dl>
			<dd><span class="pole">Эл. почта</span>
				<input type="text" name="email">
			</dd>
			<dd><span class="pole">Пароль</span>
				<input type="password" name="password">
			</dd>
			<dd><span class="pole">Повторите</span>
				<input type="password" name="repeat_password">
			</dd>
		</dl>
	</div>
	<button name="submit" type="submit" value="">Зарегистрироваться</button>
</form>