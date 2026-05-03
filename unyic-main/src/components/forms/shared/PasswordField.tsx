import type { FieldError } from "react-hook-form";
import InputField from "./InputField";

interface PasswordFieldProps {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  register: any;
  error?: FieldError;
  isRegistration?: boolean;
}

const PasswordField = ({
  register,
  error,
  isRegistration = false,
}: PasswordFieldProps) => {
  return (
    <InputField
      id="password"
      label="Password"
      type="password"
      placeholder={isRegistration ? "Create a password" : "Enter password"}
      registerProps={register("password", {
        required: "Password is required",
        ...(isRegistration && {
          minLength: {
            value: 8,
            message: "Password must be at least 8 characters long",
          },
        }),
      })}
      error={error}
    />
  );
};

export default PasswordField;
