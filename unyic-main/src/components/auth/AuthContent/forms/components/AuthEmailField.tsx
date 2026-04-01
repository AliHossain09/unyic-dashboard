import type { FieldError } from "react-hook-form";
import AuthInputField from "./AuthInputField";

interface AuthEmailFieldProps {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  register: any;
  error?: FieldError;
}

const AuthEmailField = ({ register, error }: AuthEmailFieldProps) => {
  return (
    <AuthInputField
      id="email"
      label="Email"
      type="email"
      placeholder="Enter your email"
      registerProps={register("email", {
        required: "Email is required",
        pattern: {
          value: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
          message: "Please enter a valid email address",
        },
      })}
      error={error}
    />
  );
};

export default AuthEmailField;
