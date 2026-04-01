import { useState, useRef, useEffect } from "react";
import DropdownButton from "./DropdownButton";
import DropdownList from "./DropdownList";

interface DropdownSelectorProps {
  selected: string | null;
  list: string[];
  onSelect: (value: string) => void;
  defaultText?: string;
  disabled?: boolean;
}

const DropdownSelector = ({
  selected,
  list,
  onSelect,
  defaultText = "Select",
  disabled = false,
}: DropdownSelectorProps) => {
  const [isOpen, setIsOpen] = useState(false);
  const dropdownRef = useRef<HTMLDivElement>(null);

  // Toggle dropdown
  const toggleDropdown = () => {
    if (!disabled) {
      setIsOpen((prev) => !prev);
    }
  };

  // Select item and close dropdown
  const handleSelect = (item: string) => {
    if (!disabled) {
      onSelect(item);
      setIsOpen(false);
    }
  };

  // Close on outside click
  useEffect(() => {
    const handleClickOutside = (event: MouseEvent) => {
      if (
        dropdownRef.current &&
        !dropdownRef.current.contains(event.target as Node)
      ) {
        setIsOpen(false);
      }
    };

    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  return (
    <div
      ref={dropdownRef}
      className="w-full relative bg-light text-sm"
      aria-label="Dropdown selector"
    >
      <DropdownButton
        isOpen={isOpen}
        disabled={disabled}
        selected={selected}
        defaultText={defaultText}
        onClick={toggleDropdown}
      />

      <DropdownList
        list={list}
        selected={selected}
        isOpen={isOpen}
        disabled={disabled}
        onSelect={handleSelect}
      />
    </div>
  );
};

export default DropdownSelector;
