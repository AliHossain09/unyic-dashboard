import clsx from "clsx";
import DropdownListItem from "./DropdownListItem";

interface DropdownListProps {
  list: string[];
  selected: string | null;
  isOpen: boolean;
  disabled: boolean;
  onSelect: (value: string) => void;
}

const DropdownList: React.FC<DropdownListProps> = ({
  list,
  selected,
  isOpen,
  disabled,
  onSelect,
}) => {
  return (
    <ul
      className={clsx(
        "w-full mt-1 py-1 border rounded shadow-lg border-dark-light bg-light",
        "absolute z-20 right-0 origin-top transition-transform duration-300",
        {
          "scale-100 opacity-100": isOpen,
          "scale-0 opacity-0": !isOpen,
          "pointer-events-none": disabled,
        }
      )}
      role="listbox"
    >
      {list.map((item) => (
        <DropdownListItem
          key={item}
          item={item}
          isSelected={item === selected}
          disabled={disabled}
          onSelect={onSelect}
        />
      ))}
    </ul>
  );
};

export default DropdownList;
