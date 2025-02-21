# Frontend Structure

The `frontend` folder contains the React-based user interface for Spoodler. It uses Vite for fast builds and Tailwind CSS for styling. Here's a high-level overview of the structure:

- **eslint.config.js**: Configures ESLint for consistent code quality and style.
- **index.html**: The main HTML template for the React application.
- **package.json** & **package-lock.json**: Manage project dependencies and scripts.
- **tailwind.config.js**: Custom Tailwind CSS settings.
- **vite.config.js**: Vite configuration for optimized development and builds.

- **ssl/**: Stores SSL certificates (`cert.pem` and `key.pem`) for secure HTTPS connections.

- **src/**: Main source folder containing:

  - **api/**: Custom hooks for API communication, like `useFetch.jsx`.
  - **assets/**: Static images and icons.
  - **components/**: Reusable UI components (e.g., `Navbar`, `Button`, `ErrorsTable`).
  - **layouts/**: Layout components like `MainLayout.jsx` for consistent UI structure.
  - **pages/**: Different application views, such as:
    - `ErrorPage.jsx`, `LoginPage.jsx`, and more.
  - **style/**: Global and component-specific CSS files.
