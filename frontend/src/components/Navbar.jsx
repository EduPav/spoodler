import logo from "../assets/logo.png";
import { NavLink, useLocation } from "react-router-dom";

function Navbar() {
  const location = useLocation();

  // Define your custom titles for each route
  const routeTitles = {
    "/": "Error Reports",      // Home is the Errors page
    "/errors": "Error Reports",
  };
  const currentPageTitle = routeTitles[location.pathname] || "";

  const linkClasses = ({ isActive }) =>
    `hover:text-highlight transition ${isActive ? "font-bold" : ""}`;

  return (
    <div className="grid grid-cols-3 items-center bg-primary text-softGray shadow-md p-4">
      {/* Left: Logo and App Name */}
      <div className="flex items-center">
        <img src={logo} alt="Logo" className="w-14" />
        <h1 className="text-2xl font-bold ml-2">Spoodler</h1>
      </div>

      {/* Center: Current Page Title */}
      <div className="flex justify-center">
        <h2 className="text-xl font-bold">{currentPageTitle}</h2>
      </div>

      {/* Right: Navigation Links */}
      <div className="flex justify-end">
        <ul className="flex space-x-4">
          <li>
            <NavLink to="errors" className={linkClasses}>
              Errors
            </NavLink>
          </li>
        </ul>
      </div>
    </div>
  );
}

export default Navbar;
