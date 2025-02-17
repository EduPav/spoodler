// import React from "react";
import ErrorsPage from "./pages/ErrorsPage";
import StatisticsPage from "./pages/StatisticsPage";
import ErrorPage from "./pages/ErrorPage";
import NotFoundPage from "./pages/NotFoundPage";
import InternalErrorPage from "./pages/InternalErrorPage";
import MainLayout from "./layouts/MainLayout";
import {
  Route, createBrowserRouter, createRoutesFromElements, RouterProvider, Navigate
} from "react-router-dom";
import Navbar from "./components/Navbar";
import LoginPage from "./pages/LoginPage";
import RegisterPage from "./pages/RegisterPage";

const router = createBrowserRouter(
  createRoutesFromElements(
    // <Route path="/" element={<MainLayout />}>
    <Route path="/" element={<MainLayout />} errorElement={<><Navbar /><InternalErrorPage /></>}>
      <Route index element={<Navigate to="/errors" replace />} />
      <Route path="/login" element={<LoginPage />}/>
      <Route path="/register" element={<RegisterPage />}/>
      <Route path="/errors" element={<ErrorsPage />}/>
      <Route path="/errors/:id" element={<ErrorPage />}/>
      <Route path="/statistics" element={<StatisticsPage />} />
      <Route path="*" element={<NotFoundPage message="Oops! We couldn't find that page." />} />
    </Route>
  )
)

function App() {
  return <RouterProvider router={router}/>
}

export default App;
