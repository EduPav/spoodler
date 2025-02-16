import React from "react";

const variants = {
  primary: "bg-highlight hover:bg-blue-700 text-white",
  danger: "bg-error hover:bg-red-700 text-white",
  outline: "border border-gray-600 text-gray-600 hover:bg-gray-100",
};

const Button = ({ children, variant = "primary", onClick, className = "", disabled = false, ...props }) => {
  const variantClasses = variants[variant] || variants.primary;
  const disabledClasses = disabled ? "opacity-50 cursor-not-allowed" : "";

  return (
    <button
      type="button"
      className={`px-4 py-2 rounded font-medium transition-colors ease-in-out duration-150 ${variantClasses} ${disabledClasses} ${className}`}
      onClick={disabled ? undefined : onClick}
      disabled={disabled}
      {...props}
    >
      {children}
    </button>
  );
};

export default Button;

