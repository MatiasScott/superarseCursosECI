

<div class="perfil-card mejorada">
    <div class="perfil-header mejorada">
        <div class="perfil-avatar mejorada">
            <span><?php echo strtoupper(substr($_SESSION['nombre'] ?? 'U', 0, 1)); ?></span>
        </div>
        <div class="perfil-titulo">
            <h2>Mi Perfil</h2>
            <p class="perfil-desc">Aquí puedes ver y editar tus datos personales.</p>
        </div>
    </div>
    <div class="perfil-info mejorada">
        <div class="perfil-row mejorada"><i class="fas fa-user"></i><span class="perfil-label">Nombre y Apellido</span><span class="perfil-value"><?php echo $_SESSION['nombre'] ?? 'No disponible'; ?></span></div>
        <div class="perfil-row mejorada"><i class="fas fa-envelope"></i><span class="perfil-label">Correo electrónico</span><span class="perfil-value"><?php echo $_SESSION['email'] ?? 'No disponible'; ?></span></div>
    </div>
    <div class="perfil-actions mejorada">
        <button class="btn-editar mejorada" onclick="document.getElementById('modalEditar').style.display='block'">
            <i class="fas fa-edit"></i> Editar perfil
        </button>
    </div>
    <div class="volver-actions">
        <a href="<?= URL_BASE ?>home" class="btn-volver">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </a>
    </div>
</div>

<!-- Modal de edición -->
<div id="modalEditar" class="modal-editar">
    <div class="modal-content">
        <span class="close-modal" onclick="document.getElementById('modalEditar').style.display='none'">&times;</span>
        <h3>Editar Perfil</h3>
        <form class="form-editar">
            <div class="form-group">
                <label for="nombre">Nombre y Apellido</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $_SESSION['nombre'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="<?php echo $_SESSION['email'] ?? ''; ?>">
            </div>
            <button type="submit" class="btn-guardar">Guardar cambios</button>
        </form>
    </div>
</div>

<style>
.volver-actions {
    text-align: center;
    margin-top: 2.5rem;
}
.btn-volver {
    background: linear-gradient(90deg, #FFD700 80%, #FFC300 100%);
    color: #222;
    border: none;
    border-radius: 22px;
    padding: 0.8rem 2.2rem;
    font-weight: 700;
    font-size: 1.13rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.10);
    cursor: pointer;
    transition: background 0.2s, box-shadow 0.2s;
    letter-spacing: 0.5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    margin-top: 0.5rem;
}
.btn-volver i {
    margin-right: 0.7rem;
}
.btn-volver:hover {
    background: linear-gradient(90deg, #FFC300 80%, #FFD700 100%);
    box-shadow: 0 4px 18px rgba(255,215,0,0.13);
}
.modal-content {
    background: #fff;
    margin: 7% auto;
    padding: 2.2rem 2.5rem 2rem 2.5rem;
    border-radius: 22px;
    max-width: 400px;
    width: 96vw;
    box-shadow: 0 8px 48px rgba(0,0,0,0.18);
    position: relative;
    animation: fadeInPerfil 0.5s;
}
.modal-content h3 {
    margin-top: 0;
    color: #444;
    font-size: 2rem;
    font-weight: 800;
    text-align: center;
    letter-spacing: 0.5px;
    margin-bottom: 2rem;
}
.form-editar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-top: 0.5rem;
}
.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}
.form-group label {
    color: #222;
    font-weight: 700;
    font-size: 1.15rem;
    margin-bottom: 0.2rem;
    letter-spacing: 0.2px;
}
.form-group input {
    width: 100%;
    padding: 0.7rem 1rem;
    border-radius: 14px;
    border: 1.5px solid #eaeaea;
    font-size: 1.18rem;
    background: #f8f9fa;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    transition: border 0.2s, box-shadow 0.2s;
}
.form-group input:focus {
    border: 2px solid #FFD700;
    outline: none;
    box-shadow: 0 4px 18px rgba(255,215,0,0.10);
}
.btn-guardar {
    background: linear-gradient(90deg, #FFD700 80%, #FFC300 100%);
    color: #222;
    border: none;
    border-radius: 22px;
    padding: 0.9rem 0;
    font-weight: 700;
    font-size: 1.18rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.10);
    cursor: pointer;
    margin-top: 1.2rem;
    transition: background 0.2s, box-shadow 0.2s;
    width: 100%;
    letter-spacing: 0.5px;
    text-align: center;
    display: block;
}
.btn-guardar:hover {
    background: linear-gradient(90deg, #FFC300 80%, #FFD700 100%);
    box-shadow: 0 4px 18px rgba(255,215,0,0.13);
}
/* Mejorar formulario de edición */
.form-editar {
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
    margin-top: 1.2rem;
}
.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}
.form-group label {
    color: #222;
    font-weight: 600;
    font-size: 1.07rem;
    margin-bottom: 0.2rem;
}
.form-group input {
    width: 100%;
    padding: 0.55rem 0.8rem;
    border-radius: 8px;
    border: 1px solid #eaeaea;
    font-size: 1.08rem;
    margin-bottom: 0.1rem;
    background: #f8f9fa;
    transition: border 0.2s;
}
.form-group input:focus {
    border: 1.5px solid #FFD700;
    outline: none;
}
.perfil-card.mejorada {
    max-width: 480px;
    margin: 3.5rem auto;
    background: linear-gradient(135deg, #fff 80%, #fdfbf7 100%);
    border-radius: 24px;
    box-shadow: 0 8px 48px rgba(0,0,0,0.13);
    padding: 2.5rem 2.7rem 2rem 2.7rem;
    font-family: 'Segoe UI', Arial, sans-serif;
    animation: fadeInPerfil 0.7s;
    position: relative;
}
@keyframes fadeInPerfil {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: none; }
}
.perfil-header.mejorada {
    display: flex;
    align-items: center;
    gap: 1.7rem;
    margin-bottom: 2.2rem;
    border-bottom: 1px solid #f2efe0;
    padding-bottom: 1.2rem;
}
.perfil-avatar.mejorada {
    width: 74px;
    height: 74px;
    background: #222;
    color: #FFD700;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.6rem;
    font-weight: bold;
    border: 4px solid #FFD700;
    box-shadow: 0 2px 12px rgba(0,0,0,0.13);
}
.perfil-titulo h2 {
    font-size: 2.3rem;
    font-weight: 700;
    margin: 0;
    color: #444;
    letter-spacing: 0.5px;
}
.perfil-titulo .perfil-desc {
    color: #7f8c8d;
    font-size: 1.13rem;
    margin-top: 0.5rem;
}
.perfil-info.mejorada {
    margin-top: 2.2rem;
    margin-bottom: 1.2rem;
}
.perfil-row.mejorada {
    display: flex;
    align-items: center;
    gap: 1.1rem;
    margin-bottom: 1.3rem;
    font-size: 1.15rem;
    background: #f8f9fa;
    border-radius: 12px;
    padding: 0.7rem 1rem;
    box-shadow: 0 1px 6px rgba(0,0,0,0.04);
}
.perfil-label {
    font-weight: 600;
    color: #222;
    min-width: 120px;
    font-size: 1.08rem;
}
.perfil-value {
    color: #444;
    font-weight: 500;
    font-size: 1.08rem;
}
.perfil-row.mejorada i {
    color: #FFD700;
    font-size: 1.35rem;
    min-width: 28px;
    text-align: center;
}
.perfil-actions.mejorada {
    text-align: center;
    margin-top: 2.2rem;
}
.btn-editar.mejorada {
    background: linear-gradient(90deg, #FFD700 80%, #FFC300 100%);
    color: #222;
    border: none;
    border-radius: 22px;
    padding: 0.8rem 2.2rem;
    font-weight: 700;
    font-size: 1.13rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.10);
    cursor: pointer;
    transition: background 0.2s, box-shadow 0.2s;
    letter-spacing: 0.5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    width: 100%;
    max-width: 320px;
}
.btn-editar.mejorada i {
    margin-right: 0.7rem;
}
.btn-editar.mejorada:hover {
    background: linear-gradient(90deg, #FFC300 80%, #FFD700 100%);
    box-shadow: 0 4px 18px rgba(255,215,0,0.13);
}
/* Modal */
.modal-editar {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0; top: 0; width: 100vw; height: 100vh;
    background: rgba(0,0,0,0.18);
    overflow-y: auto;
    padding: 2.5vw 0;
}
.modal-content {
    background: #fff;
    margin: 7% auto;
    padding: 2rem 2.5rem 1.5rem 2.5rem;
    border-radius: 16px;
    max-width: 370px;
    width: 92vw;
    box-shadow: 0 4px 32px rgba(0,0,0,0.13);
    position: relative;
    animation: fadeInPerfil 0.5s;
}
@media (max-width: 600px) {
  .modal-content {
    padding: 1.2rem 0.7rem 1rem 0.7rem;
    max-width: 98vw;
    font-size: 1rem;
  }
}
</style>
