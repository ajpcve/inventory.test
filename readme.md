# Test Caribbean Dairy - Bufalinda USA

## Descripción

El proyecto contiene un sistema de manejo de inventario y facturación para la empresa **Caribbean Dairy** el cual esta basado en laravel V5 con base de datos MySql.

## Requerimientos

Los requerimientos comprenden:
- Realizar el Fork del proyecto donde encontraran:
    - Proyecto Laravel de la aplicación
    - Utilizar el archivo ubicado en la raiz del proyecto `inventory_test.sql` como base de datos.
- Puesta en marcha de la aplicación.
- Acceso al sistema utilizando las credenciales
    - Usuario: `admin@admin.com`
    - Clave: `admin`
- Verificar que todas las secciones del módulo `Master` funcionan correctamente.
- Verificar y corregir el bug que afecta a la sección `Inventory -> Stock`
- Verificar y corregir el bug que afecta a la sección `Inventory -> Order Form`
- Verificar y corregir el bug que afecta a la sección `Inventory -> Transfer`
- Verificar y corregir el bug que afecta a la vista preliminar del pdf en `Inventory -> History Sale -> Detail -> Export PDF`
- Crear la sección `My Profile` que permita administrar los datos del **Usuario en sesión**. Debe contar con los siguientes campos:
    - Nombre completo. (Requerido)
    - Telefono. (Requerido)
    - Email. (Requerido)
    - Dirección.
    - Pais.
    - Tipo de Usuario (No modificable)
    - Estado (No modificable)