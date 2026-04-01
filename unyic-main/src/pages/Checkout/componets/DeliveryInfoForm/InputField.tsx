import clsx from "clsx";
import type { FieldError } from "react-hook-form";

interface InputFieldProps {
  id: string;
  type?: "text" | "number" | "email" | "tel";
  label: string;
  placeholder: string;
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  registerProps: any;
  error?: FieldError;
}

const InputField = ({
  id,
  type = "text",
  label,
  placeholder,
  registerProps,
  error,
}: InputFieldProps) => {
  return (
    <div className="space-y-1">
      <label htmlFor={id} className="block mb-1">
        {label}
      </label>

      <input
        id={id}
        type={type}
        placeholder={placeholder}
        {...registerProps}
        className={clsx("form-input", error && "border-red-500")}
      />

      {error && <p className="text-red-500 text-sm">{error.message}</p>}
    </div>
  );
};

export default InputField;
