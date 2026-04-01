import { useState } from "react";
import clsx from "clsx";
import type { FieldError } from "react-hook-form";
import { PiEye, PiEyeClosed } from "react-icons/pi";

interface AuthInputFieldProps {
  id: string;
  label: string;
  type?: "text" | "email" | "password";
  placeholder?: string;
  registerProps: object;
  error?: FieldError;
}

const AuthInputField = ({
  id,
  label,
  type = "text",
  placeholder,
  registerProps,
  error,
}: AuthInputFieldProps) => {
  const [showPassword, setShowPassword] = useState(false);

  const togglePasswordVisibility = () => {
    setShowPassword((prev) => !prev);
  };

  const isPasswordField = type === "password";
  const inputType = isPasswordField
    ? showPassword
      ? "text"
      : "password"
    : type;

  return (
    <div className="space-y-1">
      <label htmlFor={id}>{label}</label>

      <div className="mt-1 relative">
        <input
          type={inputType}
          id={id}
          placeholder={placeholder}
          className={clsx("form-input", error && "border-red-500")}
          {...registerProps}
        />

        {isPasswordField && (
          <button
            type="button"
            className="absolute top-1/2 -translate-y-1/2 right-2 text-dark-light"
            onClick={togglePasswordVisibility}
          >
            {showPassword ? <PiEye /> : <PiEyeClosed />}
          </button>
        )}
      </div>

      {error && <p className="text-red-500 text-sm mt-1">{error.message}</p>}
    </div>
  );
};

export default AuthInputField;
