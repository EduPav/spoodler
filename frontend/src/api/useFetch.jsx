import { useEffect, useState } from "react"
import { useNavigate } from "react-router-dom";

const useFetch = (url) => {

    const [data, setData] = useState([])
    const [message, setMessage] = useState("");
    const [loading, setLoading] = useState(true)
    const [internalException, setInternalException] = useState(false);
    const [notFoundException, setNotFoundException] = useState(false);
    const navigate = useNavigate();

    useEffect(() => {
        if (!url) {
            setLoading(false);
            return;
        }
        // Resets vars on new fetch
        setInternalException(false);
        setNotFoundException(false);
        setLoading(true);
        const fetchErrors = async () => {
            try {
                const token = sessionStorage.getItem("token");
                const headers = token ? { Authorization: `Bearer ${token}` } : {};
                const response = await fetch(url, { headers: headers });
                const data = await response.json();
                setData(data.data);
                if (response.status == 404) {
                    setNotFoundException(true);
                    setMessage(data.message);
                }
                else if (response.status == 401) {
                    navigate("/login");
                }
                else if (response.status >= 400) {
                    setInternalException(true);
                }
            } catch (exception) {
                console.error("Error fetching data:", exception);
                setInternalException(true);
            }
            setLoading(false);
        };
        fetchErrors();
    }, [url]);

    return { data, message, loading, internalException, notFoundException };
}

export default useFetch;