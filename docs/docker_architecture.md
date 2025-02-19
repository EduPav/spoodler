# Spoodler Docker Architecture

Five main containers running inside a custom **Docker network** (spoodler_network). Each container serves a specific role:

## 1. React (Frontend)

- **Container Name**: spoodler_frontend
- **Purpose**: Serves the React UI for Spoodler.
- **Exposed Ports**: 3443:3443

## 2. Nginx (Reverse Proxy & Static Files)

- **Container Name**: spoodler_nginx
- **Purpose**: Serves as a reverse proxy, handling HTTP and HTTPS requests and directing them to the appropriate services.
- **Exposed Ports**:
  8080:80 → HTTP
  8443:443 → HTTPS

## 3. PHP (Backend)

- **Container Name**: spoodler_php
- **Purpose**: Runs the PHP application with FPM.

## 4. MySQL (Production Database)

- **Container Name**: spoodler_db
- **Purpose**: Stores production data.
- **Exposed Ports**: 3306:3306

## 5. MySQL (Testing Database)

- **Container Name**: spoodler_test_db
- **Purpose**: Provides a separate testing database.
- **Exposed Ports**: 3307:3306

# Docker Architecture Diagram

![alt text](img/docker.png)