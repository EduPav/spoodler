import { useParams, Link } from "react-router-dom";
import useFetch from "../api/useFetch";
import Spinner from "../components/Spinner";
import Button from "../components/Button";
import InternalErrorPage from "./InternalErrorPage";
import NotFoundPage from "./NotFoundPage";
import ErrorTable from "../components/ErrorTable";
import AIHelp from "../components/AIHelp";

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
        <ErrorTable error={error} />
        <AIHelp errorId={id} />
      </div>
    </div>
  );
};

export default SingleErrorPage;
