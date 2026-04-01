import clsx from "clsx";

interface DropdownListItemProps {
  item: string;
  isSelected: boolean;
  disabled: boolean;
  onSelect: (value: string) => void;
}

const DropdownListItem: React.FC<DropdownListItemProps> = ({
  item,
  isSelected,
  disabled,
  onSelect,
}) => {
  return (
    <li role="option" aria-selected={isSelected}>
      <button
        onClick={() => onSelect(item)}
        className={clsx(
          "block w-full px-4 py-2 text-left",
          isSelected ? "bg-primary-dark text-light" : "hover:bg-gray-300/30",
          disabled && "cursor-not-allowed"
        )}
        disabled={disabled}
      >
        {item}
      </button>
    </li>
  );
};

export default DropdownListItem;
