# Todo Tops - Tienda Virtual WordPress

Tienda virtual desarrollada con WordPress y Docker para "Todo Tops".

## 🚀 Inicio Rápido

### Prerequisitos
- Docker Desktop instalado y ejecutándose
- Puerto 80 y 8080 disponibles

### Instalación

1. **Clonar o descargar el proyecto**
```bash
cd practica_exposición
```

2. **Levantar los contenedores**
```bash
docker-compose up -d
```

3. **Acceder a la tienda**
- **Sitio web**: http://localhost
- **Panel de administración**: http://localhost/wp-admin
- **phpMyAdmin**: http://localhost:8080

### Configuración inicial de WordPress

1. Visita http://localhost
2. Selecciona idioma (Español)
3. Completa la configuración:
   - **Título del sitio**: Todo Tops
   - **Nombre de usuario**: admin
   - **Contraseña**: (genera una segura)
   - **Email**: tu-email@ejemplo.com

## 📁 Estructura del Proyecto

```
practica_exposición/
├── docker-compose.yml    # Configuración de contenedores
├── .env                 # Variables de entorno
├── nginx.conf           # Configuración del servidor web
├── wp-content/          # Plugins, temas y uploads de WordPress
└── README.md           # Este archivo
```

## 🛠 Comandos Útiles

### Gestión de contenedores
```bash
# Iniciar todos los servicios
docker-compose up -d

# Parar todos los servicios
docker-compose down

# Ver logs
docker-compose logs -f

# Reiniciar un servicio específico
docker-compose restart wordpress
```

### Acceso a contenedores
```bash
# Acceder al contenedor de WordPress
docker exec -it todo_tops_wordpress bash

# Acceder al contenedor de MySQL
docker exec -it todo_tops_mysql mysql -u root -p
```

## 🔐 Credenciales por Defecto

### Base de datos
- **Host**: db
- **Puerto**: 3306
- **Base de datos**: todo_tops_db
- **Usuario**: todo_tops_user
- **Contraseña**: todo_tops_pass_2024

### phpMyAdmin
- **URL**: http://localhost:8080
- **Usuario**: root
- **Contraseña**: todo_tops_root_2024

## 🛒 Configuración para E-commerce

Para convertir el sitio en una tienda virtual:

1. **Instalar WooCommerce**
   - Ve a Plugins > Añadir nuevo
   - Busca "WooCommerce"
   - Instala y activa

2. **Configurar WooCommerce**
   - Sigue el asistente de configuración
   - Configura métodos de pago
   - Establece opciones de envío

3. **Temas recomendados**
   - Storefront (gratuito)
   - Astra + WooCommerce
   - OceanWP

## 🔧 Personalización

### Cambiar configuraciones
Edita el archivo `.env` y reinicia los contenedores:
```bash
docker-compose down && docker-compose up -d
```

### Instalar plugins y temas
Los archivos se guardan en `./wp-content/` y persisten entre reinicios.

## ❗ Solución de Problemas

### Puerto ocupado
Si el puerto 80 está ocupado:
```yaml
# En docker-compose.yml, cambiar:
ports:
  - "8000:80"  # Usar puerto 8000 en su lugar
```

### Problemas de permisos
```bash
# Dar permisos al directorio wp-content
chmod -R 755 wp-content
```

### Reset completo
```bash
docker-compose down -v
docker-compose up -d
```

## 📞 Soporte

Para problemas específicos de WordPress o WooCommerce, consulta:
- [Documentación de WordPress](https://wordpress.org/support/)
- [Documentación de WooCommerce](https://woocommerce.com/documentation/)