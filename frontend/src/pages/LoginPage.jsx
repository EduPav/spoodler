import { useState } from "react";
import { useNavigate } from "react-router-dom";
import Button from "../components/Button";
import { NavLink } from "react-router-dom";

const LoginPage = () => {
  const navigate = useNavigate();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError("");

        try {
            const response = await fetch("/api/users/login", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ "email":email, "password":password }),
            });

            if (!response.ok) {
                const err = await response.json();
                setError(err.message || "Login failed");
                setLoading(false);
                return;
            }
            const token = (await response.json()).data.token;
            sessionStorage.setItem("token", token);
            navigate("/errors");
        } catch {
            setError("An unexpected error occurred.");
            setLoading(false);
        }
    };

  return (
    <div className="min-h-screen bg-softGray flex items-center justify-center">
      <div className="bg-primary rounded-lg shadow w-full max-w-md p-6">
        <h1 className="text-2xl font-bold mb-4 text-center text-softBlue">Login</h1>
        {error && <div className="mb-4 text-error">{error}</div>}
        <form onSubmit={handleSubmit}>
          <div className="mb-4">
            <label htmlFor="email" className="block text-xl font-bold mb-1 text-softBlue">
              Email:
            </label>
            <input
              type="email"
              id="email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              className="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
              required
            />
          </div>
          <div className="mb-6">
            <label htmlFor="password" className="block text-xl font-bold mb-1 text-softBlue">
              Password:
            </label>
            <input
              type="password"
              id="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              className="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"
              required
            />
          </div>
          <Button variant="primary" type="submit" disabled={loading}>
            {loading ? "Logging in..." : "Login"}
          </Button>
        </form>
        <p className="mt-4 text-center text-softBlue">
          Don't have an account?{" "}
          <NavLink to="/register" className="text-highlight underline">
            Register here
          </NavLink>
        </p>
      </div>
    </div>
  );
};

export default LoginPage;
