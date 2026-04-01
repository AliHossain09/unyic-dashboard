import type { FieldError } from "react-hook-form";
import AuthInputField from "./AuthInputField";

interface AuthPasswordFieldProps {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  register: any;
  error?: FieldError;
}

const AuthPasswordField = ({ register, error }: AuthPasswordFieldProps) => {
  return (
    <AuthInputField
      id="password"
      label="Password"
      type="password"
      placeholder="Create a password"
      registerProps={register("password", {
        required: "Password is required",
        minLength: {
          value: 6,
          message: "Password must be at least 6 characters long",
        },
      })}
      error={error}
    />
  );
};

export default AuthPasswordField;
