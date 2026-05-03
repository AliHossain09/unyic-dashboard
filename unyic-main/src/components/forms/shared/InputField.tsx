import { useState } from "react";
import clsx from "clsx";
import type { FieldError } from "react-hook-form";
import { PiEye, PiEyeClosed } from "react-icons/pi";

interface InputFieldProps {
  id: string;
  label: string;
  type?: "text" | "email" | "password" | "number" | "tel";
  placeholder?: string;
  registerProps: object;
  error?: FieldError;
}

const InputField = ({
  id,
  label,
  type = "text",
  placeholder,
  registerProps,
  error,
}: InputFieldProps) => {
  const [showPassword, setShowPassword] = useState(false);

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
          id={id}
          type={inputType}
          placeholder={placeholder}
          className={clsx("form-input", error && "border-red-500")}
          {...registerProps}
        />

        {isPasswordField && (
          <button
            type="button"
            className="absolute top-1/2 -translate-y-1/2 right-2 text-dark-light"
            onClick={() => setShowPassword((prev) => !prev)}
          >
            {showPassword ? <PiEye /> : <PiEyeClosed />}
          </button>
        )}
      </div>

      {error && <p className="text-red-500 text-sm">{error.message}</p>}
    </div>
  );
};

export default InputField;
