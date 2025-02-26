import { Link } from "react-router-dom";
import errorImage from "../assets/drawing500.png";

const InternalErrorPage = () => {
  return (
    <div
      className="flex flex-col items-center justify-center errorBg overflow-hidden"
    >
      {/* Number */}
      <h1 className="text-6xl sm:text-8xl md:text-9xl font-bold text-error">
        500
      </h1>
          
      {/* Error Message */}
      <p className="text-lg md:text-3xl text-softGray">
        Internal Server Error
      </p>
      <p className="text-lg md:text-md text-softGray">
        Sorry, we are working on it!
      </p>    

      
      {/* Drawing below the number */}
      <img 
        src={errorImage} 
        alt="500 Internal Server Error"
        className="w-3/4 max-w-md md:max-w-lg object-cover my-3"
      />
      
      {/* Go Home Button */}
      <Link 
        to="/" 
        className="inline-block mt-6 px-4 py-2 bg-error text-white rounded-md hover:bg-blue-600 text-base sm:text-lg"
      >
        🏠 Go Home
      </Link>
    </div>
  );
};

export default InternalErrorPage;
