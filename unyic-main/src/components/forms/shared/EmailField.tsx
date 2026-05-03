import type { FieldError } from "react-hook-form";
import InputField from "./InputField";

interface EmailFieldProps {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  register: any;
  error?: FieldError;
}

const EmailField = ({ register, error }: EmailFieldProps) => {
  return (
    <InputField
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

export default EmailField;
