<label for="id_falla" title="Aquí se muestra el código único de la falla.">Código de falla</label><br>
<input type="text" name="id_falla" value="<?=$id_falla?>" readonly><br><br>

<label for="hora_fecha" title="Fecha y hora en que se abre la falla.">Fecha y Hora de Apertura</label><br>
<input type="datetime-local" name="hora_fecha" value="<?=$hora_fecha?>" readonly><br><br>

<label for="metodo_reporte" title="Seleccione el método utilizado para reportar la falla.">Método de Reporte</label><br>
<select name="metodo_reporte" id="metodo_reporte" required>
    <option value="">Seleccionar</option>
    <option value="Email">Email</option>
    <option value="Llamada">Llamada</option>
    <option value="Telegram">Telegram</option>
    <option value="WhatsApp">WhatsApp</option>
</select>
<br><br>

<label for="recibida_ccf" title="Seleccione la persona que recibió el reporte en CCF.">Recibida CCF</label><br>
<select name="recibida_ccf" id="recibida_ccf" required>
    <option value="">Seleccionar</option>
    <?php while($row = $recibida_ccf->fetch_assoc()) { ?>
        <option value="<?php echo $row['id_personal']; ?>"><?php echo $row['id_personal'] . ' - ' . $row['nombre_personal'] . ' ' . $row['apellido_personal']; ?></option>
    <?php } ?>
</select>
<br><br>

<label for="reportada_por" title="Seleccione la persona que reportó la falla.">Reportada Por</label><br>
<select name="reportada_por" id="reportada_por" required>
    <option value="">Seleccionar</option> 
    <?php while($row = $reportada_por->fetch_assoc()) { ?>
        <option value="<?php echo $row['id_personal']; ?>"><?php echo $row['id_personal'] . ' - ' . $row['nombre_personal'] . ' ' . $row['apellido_personal']; ?></option>
    <?php } ?>
</select>
<br><br>

<label for="servicio" title="Seleccione el servicio relacionado con la falla.">Servicio</label><br>
<select name="servicio" id="servicio" required>
    <option value="">Seleccionar</option>
    <?php while($row = $servicio->fetch_assoc()) { ?>
        <option value="<?php echo $row['id_servicio']; ?>"><?php echo $row['nombre_servicio']; ?></option>
    <?php } ?>
</select>
<br><br>

<label for="sub_sistema" title="Seleccione el subsistema afectado por la falla.">Sub Sistema</label><br>
<select name="sub_sistema" id="sub_sistema" required>
    <option value="">Seleccionar</option>
</select>
<br><br>

<label for="equipo" title="Seleccione el equipo relacionado con la falla.">Equipo</label><br>
<select name="equipo" id="equipo" required>
    <option value="">Seleccionar</option>
</select><br><br>

<label for="ubicacion" title="Seleccione la ubicación donde ocurrió la falla.">Ubicación</label><br>
<select name="ubicacion" id="ubicacion" required>
    <option value="">Seleccionar</option>
    <?php while($row = $ubicacion->fetch_assoc()) { ?>
        <option value="<?php echo $row['id_ubicacion'];?>"><?php echo $row['ubicacion']; ?></option>
    <?php } ?>
</select><br><br>

<label for="detalles_ubicacion" title="Escriba detalles adicionales sobre la ubicación.">Detalles de Ubicación</label><br>
<input type="text" name="detalles_ubicacion" placeholder="Detalles de Ubicación" required>    
<br><br>

<label for="descripcion_falla" title="Proporcione una descripción detallada de la falla.">Descripción de Falla</label><br>
<input type="text" name="descripcion_falla" placeholder="Escriba una descripción" required><br><br>

<label for="responsable" title="Seleccione el responsable del área correspondiente a la falla.">Responsable de área</label><br>
<select name="responsable" id="responsable" required>
    <option value="">Seleccionar</option>
    <?php while($row = $responsable->fetch_assoc()) { ?>
        <option value="<?php echo $row['id_personal']; ?>"><?php echo $row['id_personal'] . ' - ' . $row['nombre_personal'] . ' ' . $row['apellido_personal']; ?></option>
    <?php } ?>
</select>
<br><br>

<label for="prioridad" title="Seleccione la prioridad de la falla.">Prioridad</label><br>
<select name="prioridad" id="prioridad" required>
    <option value="">Seleccionar</option>
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
</select>
<br><br>

<label for="estado" title="Seleccione el estado actual de la falla.">Estado</label><br>
<select name="estado" id="estado" required>
    <option value="">Seleccionar</option>
    <option value="Abierto">Abierto</option>
    <option value="Cerrada">Cerrada</option>
    <option value="Anulada">Anulada</option>
</select>    
<br><br>

<label for="reportada_a" title="Seleccione la persona a la que se reportó la falla.">Reportada A</label><br>
<select name="reportada_a" id="reportada_a" required>
    <option value="">Seleccionar</option>
    <?php while($row = $reportada_a->fetch_assoc()) { ?>
        <option value="<?php echo $row['id_personal']; ?>"><?php echo $row['id_personal'] . ' - ' . $row['nombre_personal'] . ' ' . $row['apellido_personal']; ?></option>
    <?php } ?> 
</select><br><br>

<label for="justificacion" title="Seleccione la justificación correspondiente a la falla.">Justificación</label><br>
<select name="justificacion" id="justificacion" required>
    <option value="">Seleccionar</option>
    <option value="Ninguno">Ninguno</option>
    <option value="Pendiente por Cierre">Pendiente por Cierre</option>
    <option value="Pendiente por Reporte">Pendiente por Reporte</option>
    <option value="Reactivación">Reactivación</option>
</select><br><br>

<label for="tecnico" title="Seleccione el técnico asignado para resolver la falla.">Técnico</label><br>
<select name="tecnico" id="tecnico" required>
    <option value="">Seleccionar</option>
    <?php while($row = $tecnico->fetch_assoc()) { ?>
        <option value="<?php echo $row['id_personal']; ?>"><?php echo $row['id_personal'] . ' - ' . $row['nombre_personal'] . ' ' . $row['apellido_personal']; ?></option>
    <?php } ?> 
</select><br><br>

<label for="acompañamiento" title="Seleccione el tipo de acompañamiento requerido.">Acompañamiento</label><br>
<select name="acompañamiento" id="acompañamiento" required>
    <option value="">Seleccionar</option>
    <?php while($row = $acompañamiento->fetch_assoc()) { ?>
        <option value="<?php echo $row['id_acompañamiento']; ?>"><?php echo $row['descripcion_acompañamiento']; ?></option>
    <?php } ?> 
</select><br><br>

<label for="cerrada_por" title="Seleccione la persona que cerró la falla.">Cerrada por</label><br>
<select name="cerrada_por" id="cerrada_por" required>
    <option value="">Seleccionar</option>
    <?php while($row = $cerrada_por->fetch_assoc()) { ?>
        <option value="<?php echo $row['id_personal']; ?>"><?php echo $row['id_personal'] . ' - ' . $row['nombre_personal'] . ' ' . $row['apellido_personal']; ?></option>
    <?php } ?> 
</select><br><br>

<label for="cerrada_ccf" title="Seleccione la persona en CCF que cerró la falla.">Cerrada CCF</label><br>
<select name="cerrada_ccf" id="cerrada_ccf" required>
<option value="">Seleccionar</option>
<?php while($row = $cerrada_ccf->fetch_assoc()) { ?>
    <option value="<?php echo $row['id_personal']; ?>"><?php echo $row['id_personal'] . ' - ' . $row['nombre_personal'] . ' ' . $row['apellido_personal']; ?></option>
<?php } ?> 
</select><br><br>

<label for="fecha_hora_cierre" title="La fecha y hora en que se cerró la falla.">Hora y Fecha de Cierre</label><br>
<input type="text" name="fecha_hora_cierre" placeholder="fecha de cierre" readonly><br><br>

<label for="dias_falla" title="Número de días que la falla ha estado abierta.">Días de Falla</label><br>
<input type="text" name="dias_falla" placeholder="Días de Falla" readonly>   

<br><br><br><br>
<div class="boton-container">
    <button class="primero" type="submit" name="btnguardar" value="GUARDAR">GUARDAR</button>
    <a href="../inicio/inicio.php"><button class="segundo" type="button" name="cancelar">CANCELAR</button></a>
</div>