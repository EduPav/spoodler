import useFetch from "../api/useFetch";
import { Link } from "react-router-dom";
import Spinner from "./Spinner";
import InternalErrorPage from "../pages/InternalErrorPage";
import NotFoundPage from "../pages/NotFoundPage";

const ErrorsTable = () => {
  const { data: errors, message, loading, internalException, notFoundException } = useFetch("/api/errors/");

  if (loading) {
    return <Spinner loading={loading} />;
  }

  if (internalException) {
    return <InternalErrorPage />;
  }

  if (notFoundException) {
    return <NotFoundPage message = {message} />;
  }

  if (errors && errors.length === 0) {
    return <NotFoundPage message = "No errors found" />;
  }
  
  return (
    <div className="p-4">
      <div className="overflow-x-auto">
        <table>
          <thead>
            <tr>
              <th className="w-[13%]">Date</th>
              <th className="w-[20%]">File</th>
              <th className="w-[20%]">Message</th>
              <th className="w-[47%]">Description</th>
            </tr>
          </thead>
            <tbody>
            {errors.map((error) => (
              <tr key={error.id}>
                <td>{error.created_at}</td>
                <td>{error.file}</td>
                <td>{error.message}</td>
                <td><Link className="text-highlight underline" to={`/errors/${error.id}`}>
                  {error.description}
                </Link></td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
};

export default ErrorsTable;
