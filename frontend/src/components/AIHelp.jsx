import { useState } from "react";
import Button from "../components/Button";
import useFetch from "../api/useFetch";
import ReactMarkdown from "react-markdown";

const AIHelp = ({ errorId }) => {
  // Initially, no advice URL so no fetch is triggered.
  const [adviceUrl, setAdviceUrl] = useState(null);
  const { data, _, loading, internalException, notFoundException } = useFetch(adviceUrl);
  
  const handleClick = () => {
    // Trigger fetching advice by setting the URL.
    setAdviceUrl(`/api/errors/${errorId}/advice?ts=${Date.now()}`);
  };

  return (
    <div className="mt-4">
      <Button variant="newFeature" onClick={handleClick} disabled={loading}>
        {loading ? "Thinking..." : "AI help me!"}
      </Button>
        {(internalException || notFoundException) && 
          <div className="mt-2 p-4 border rounded bg-white shadow">
            <p className="text-error mt-2">AI is on a coffee break! Try again later.</p>
          </div>
        }
        {data && data.advice && (
          <div className="mt-2 p-4 border rounded bg-white shadow">
            <ReactMarkdown>{data.advice}</ReactMarkdown>
          </div>
        )}
    </div>
  );
};

export default AIHelp;
