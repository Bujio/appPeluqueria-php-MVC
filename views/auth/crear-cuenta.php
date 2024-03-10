<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Rellena el siguiente formulario para crear una cuenta</p>

<form action="/crear-cuenta" class="formulario" method="POST">
  <div class="campo">
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" placeholder="tu nombre">
  </div>

  <div class="campo">
    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="apellido" placeholder="tu apellido">
  </div>

  <div class="campo">
    <label for="telefono">Teléfono</label>
    <input type="tel" id="telefono" name="telefono" placeholder="tu telefono">
  </div>

  <div class="campo">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="tu email">
  </div>

  <div class="campo">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="tu password">
  </div>

  <input type="text" class="boton" value="Crear Cuenta">
</form>
<div class="acciones">
  <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
  <a href="/olvide">¿Olvidaste tu password?</a>
</div>