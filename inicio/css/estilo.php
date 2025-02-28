<style>
  /* Personalización del scrollbar para navegadores basados en WebKit (Chrome, Safari, Edge) */
::-webkit-scrollbar {
    width: 18px; /* Ancho del scrollbar */
}

::-webkit-scrollbar-track {
   
    background: rgb(35, 41, 43);/* Color de fondo del scrollbar */
    
}

::-webkit-scrollbar-thumb {
    background-color: #495057; /* Color del "thumb" (parte que se arrastra) */
    border-radius: 30px; /* Bordes redondeados del thumb */
    background:rgb(35, 41, 43); /* Color de fondo del scrollbar */
 
}

::-webkit-scrollbar-thumb:hover {
    background-color: #495057; /* Color del "thumb" al pasar el mouse */
    

}



/* Personalización del scrollbar para Firefox */
.scrollable {
    scrollbar-color:rgb(92, 109, 126) #2c3e50; /* Color del "thumb" y del "track" */
    scrollbar-width: 18px; /* Ancho del scrollbar */
    overflow: auto; 
    max-height: 500px;
     max-width: 1400px;
     align-items: center;
     text-align: center;
}
.scrollable::-webkit-scrollbar-thumb {
    background-color: rgb(62, 66, 73); /* Color del "thumb" (parte que se arrastra) */
    border-radius: 10px; /* Bordes redondeados del thumb */
}




  .header-table {
            background-color: #2c3e50;
            color: white;
            padding: 1rem;
            border-radius: 0.5rem 0.5rem 0 0;
            align-content: center;
        }

        .status-resuelto {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pendiente {
            background-color: #fff3cd;
            color: #856404;
        }

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
body::-webkit-scrollbar-thumb {
  background-color:rgb(110, 115, 119);
  border-radius: 10px;
 
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
