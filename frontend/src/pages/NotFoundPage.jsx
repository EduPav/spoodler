import { Link } from "react-router-dom";
import notFoundImage from "../assets/drawing404.png";

const NotFoundPage = ({ message = "Oops! Seems like something is missing." }) => {
  return (
      <div className="relative errorBg overflow-hidden"
      style={{ height: "calc(100vh - 70px)" }}>
      {/* Owl Image: Bigger and closer to center */}
      <div className="absolute left-1/2 top-1/3 transform -translate-x-3/4">
        <img 
          src={notFoundImage} 
          alt="404 Not Found" 
          className="w-3/4 max-w-md md:max-w-lg object-cover"
        />
      </div>

      {/* Text Content: Positioned so its bottom touches center */}
      <div className="absolute left-1/2 top-1/2 transform -translate-y-full text-center">
        <h1 className="text-6xl sm:text-8xl md:text-9xl font-bold text-error">404</h1>
        <p className="text-lg sm:text-2xl md:text-2xl text-softGray mt-4">{message}</p>
        <Link 
          to="/" 
          className="inline-block mt-6 px-4 py-2 bg-error text-white rounded-md hover:bg-blue-600 text-base sm:text-lg"
        >
          🏠 Go Home
        </Link>
      </div>
    </div>
  );
};

export default NotFoundPage;
