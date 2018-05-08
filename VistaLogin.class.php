<?php

class VistaLogin{

	public static function login(){
		?>
		<section>
            <h2>Acceso área privada:</h2>
            
            <form class="elementos-centrados" method="post">
                <fieldset>
                    <legend>Login</legend>
                    <div class="fila">
                    	<label for="usuario">Usuario:</label>
                    	<input type="text" id="usuario" name="usuario" tabindex="1" />
                    </div>
                    <div class="fila">
                    	<label for="clave">Clave:</label>
                    	<input type="password" id="clave" name="clave" tabindex="2" />
                    </div>
                    <div class="fila">
                    	<input class="boton" type="submit" value="Aceptar" tabindex="4" />
                    	<input class="boton" id="btn-limpiar" type="reset" value="Limpiar" tabindex="3" />
                    </div>
                </fieldset>
            </form>
        </section>
		<?php
	}

	public static function errorLogin(){
		?>
		<div id="errorLogin">
			<p>Usuario o clave incorrectos</p>
		</div>
		<?php
	}
}