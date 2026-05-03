import { MdCheckBox, MdCheckBoxOutlineBlank } from "react-icons/md";

interface CheckboxFieldProps {
  id: string;
  label: string;
  registerProps: object;
}

const CheckboxField = ({ id, registerProps, label }: CheckboxFieldProps) => {
  return (
    <label htmlFor={id} className="w-max pt-1 flex gap-2 items-center">
      <input
        type="checkbox"
        id={id}
        className="hidden peer"
        {...registerProps}
      />
      <MdCheckBox
        size={22}
        className="text-primary-dark hidden peer-checked:block"
      />
      <MdCheckBoxOutlineBlank
        size={22}
        className="text-primary-dark peer-checked:hidden"
      />
      <span>{label}</span>
    </label>
  );
};

export default CheckboxField;
