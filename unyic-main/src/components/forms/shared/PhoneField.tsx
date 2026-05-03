import type { FieldError } from "react-hook-form";
import InputField from "./InputField";

interface PhoneFieldProps {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  register: any;
  error?: FieldError;
}

const PhoneField = ({ register, error }: PhoneFieldProps) => {
  return (
    <InputField
      id="phone"
      type="tel"
      label="Phone Number"
      placeholder="Enter your phone number"
      error={error}
      registerProps={register("phone", {
        required: "Phone number is required",
        pattern: {
          value: /^(?:\+?8801|01)[3-9]\d{8}$/,
          message: "Please enter a valid Bangladeshi phone number",
        },
      })}
    />
  );
};

export default PhoneField;