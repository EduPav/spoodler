import { useParams, Link } from "react-router-dom";
import useFetch from "../api/useFetch";
import Spinner from "../components/Spinner";
import Button from "../components/Button";
import InternalErrorPage from "./InternalErrorPage";
import NotFoundPage from "./NotFoundPage";

const SingleErrorPage = () => {
  const { id } = useParams();
  const { data: error, message, loading, internalException, notFoundException } = useFetch(`/api/errors/${id}`);

  if (loading) {
    return <Spinner loading={loading} />;
  }

  if (internalException) {
    return <InternalErrorPage />;
  }

  if (notFoundException) {
    return <NotFoundPage message = {message} />;
  }

  return (
    <div className="min-h-screen bg-gray-100">
      <div className="p-4">
        <Link to="/errors" className="text-blue-500 underline inline-block mb-4 py-4">
            <Button variant="primary">
                ← Back to errors
            </Button>
        </Link>
        {/* White card, full width, no overflow clipping */}
        <div className="bg-white rounded-lg shadow w-full">
          {/* Dark header (like table) */}
          <div className="rounded-t-lg p-4 border-b border-gray-200 bg-[#0a192f]">
            <h1 className="text-2xl font-bold text-white">Error Details</h1>
          </div>
          
          {/* Body with wrapping text */}
          <div className="p-4 whitespace-normal break-words">
            <div className="mb-2">
              <span className="text-xl underline font-bold">Date:</span>{" "}
              <span>{error.created_at}</span>
            </div>
            <div className="mb-2">
              <span className="text-xl underline font-bold">File:</span>{" "}
              <span>{error.file}</span>
            </div>
            <div className="mb-2">
              <span className="text-xl underline font-bold">Message:</span>{" "}
              <span>{error.message}</span>
            </div>
            <div className="mb-2">
              <span className="text-xl underline font-bold">Description:</span>
              {/* Pre-wrap + break-words ensures large blocks or long words wrap */}
              <p className="whitespace-pre-wrap break-words mt-1">{error.description}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default SingleErrorPage;
