<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<form class="formulario" method="post" action="/">
  <div class="campo">
    <label for="email">Email</label>
    <input type="email" id="email" placeholder="tu email" name="email" />
  </div>
  <div class="campo">
    <label for="password">Password</label>
    <input type="password" id="password" placeholder="tu password" name="password">
  </div>
  <input type="submit" class="boton" value="Iniciar sesión">
</form>

<div class="acciones">
  <a href="/crear-cuenta">¿Aún no tienes cuenta? Crear Cuenta</a>
  <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
</div>