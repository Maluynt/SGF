<style>


/* Sobreescribir estilos necesarios */
.main-sidebar {
    position: fixed;
    height: 100vh;
    overflow-y: auto;
}

.content-wrapper {
    margin-left: 250px;
    transition: margin-left .3s;
}

.sidebar-collapse .content-wrapper {
    margin-left: 0;
}
body {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  background-color: var(--bg-body);
}

/* Header */
header {
  position: fixed;
  top: 0;
  width: 100%;
  height: 80px;
  z-index: 2000;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Botón del menú */
.menu-btn {
  cursor: pointer;
  padding: 8px;
  display: flex;
  flex-direction: column;
  gap: 5px;
  transition: all 0.3s ease;
}

.menu-btn span {
  display: block;
  width: 30px;
  height: 3px;
  background: white;
  margin: 0;
  transition: all 0.3s ease;
  border-radius: 2px;
}

.menu-btn.active span:nth-child(1) {
  transform: rotate(45deg) translate(6px, 6px);
}

.menu-btn.active span:nth-child(2) {
  opacity: 0;
}

.menu-btn.active span:nth-child(3) {
  transform: rotate(-45deg) translate(6px, -6px);
}

/* Sidebar */
.sidebar {
  position: fixed;
  left: -300px;
  top: 80px;
  width: 300px;
  height: calc(100vh - 80px);
  background: #343a40;
  box-shadow: 3px 0 15px rgba(0,0,0,0.2);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 1500;
  overflow-y: auto;
}

.sidebar.active {
  left: 0;
}

.sidebar-menu {
  padding: 15px;
}

.menu-item {
  color: #dee2e6;
  padding: 12px 15px;
  border-radius: 5px;
  transition: all 0.3s ease;
  text-decoration: none;
  display: block;
}

.menu-item:hover {
  background-color: #495057;
  color: white !important;
}

.submenu, .user-details {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.3s ease-out;
  padding-left: 20px;
}

.submenu.show, .user-details.show {
  max-height: 500px;
}

.submenu-item {
  padding: 10px;
  color: #adb5bd;
  text-decoration: none;
  display: block;
}

.submenu-item:hover {
  background-color: #343a40;
}

.logout-btn {
  background-color: #dc3545;
  color: white !important;
  margin-top: 15px;
}

/* Contenido principal */
.main-content {
  margin-top: 80px;
  flex: 1;
  padding: 20px;
  transition: all 0.3s ease;
}

.sidebar.active ~ .main-content {
  margin-left: 300px;
  width: calc(100% - 300px);
}

/* Footer */
footer {
  position: relative;
  z-index: 1000;
  background-color: #343a40;
}</style>
