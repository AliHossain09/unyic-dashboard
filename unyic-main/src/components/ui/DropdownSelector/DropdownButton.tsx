import { TiArrowSortedDown } from "react-icons/ti";
import clsx from "clsx";

interface DropdownButtonProps {
  isOpen: boolean;
  disabled: boolean;
  selected: string | null;
  defaultText: string;
  onClick: () => void;
}

const DropdownButton: React.FC<DropdownButtonProps> = ({
  isOpen,
  disabled,
  selected,
  defaultText,
  onClick,
}) => {
  return (
    <button
      type="button"
      onClick={onClick}
      disabled={disabled}
      aria-expanded={isOpen}
      className={clsx(
        "w-full border p-2 flex items-center justify-between bg-light",
        {
          "outline-2 outline-dark-deep rounded relative z-10": isOpen,
          "bg-gray-200 bg-opacity-50 text-gray-400 cursor-default": disabled,
        }
      )}
    >
      <span className="truncate">{selected || defaultText}</span>

      <TiArrowSortedDown
        className={clsx({
          "rotate-180": isOpen,
          "text-gray-400": disabled,
        })}
      />
    </button>
  );
};

export default DropdownButton;
