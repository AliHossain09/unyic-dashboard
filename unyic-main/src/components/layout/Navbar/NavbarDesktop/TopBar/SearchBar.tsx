import clsx from "clsx";
import { useState } from "react";
import { MdOutlineSearch } from "react-icons/md";

const SearchBar = () => {
  const [showInput, setShowInput] = useState(false);
  const [inputValue, setInputValue] = useState(""); // Manage input value with state

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setInputValue(e.target.value);
  };

  const toggleInput = () => {
    if (inputValue === "") {
      setShowInput(!showInput);
    }
  };

  return (
    <div className="flex items-center gap-px">
      <div
        className={clsx(
          "py-1 relative text-sm",
          showInput ? "w-44" : "w-0",
          "duration-300 ease-in-out overflow-hidden"
        )}
      >
        {/* Search input field */}
        <input
          id="desktop-search"
          value={inputValue}
          onChange={handleInputChange}
          autoComplete="off"
          placeholder=""
          className="w-full bg-transparent focus:outline-none peer"
        />

        {/* Floating placeholder text */}
        <label
          htmlFor="desktop-search"
          className="hidden peer-placeholder-shown:block w-full absolute top-[12px] -translate-y-1/2 inset-0 text-dark-light text-nowrap"
        >
          Search what you need today
        </label>

        {/* Bottom border animation */}
        <div
          className={clsx(
            "h-px w-full bg-dark absolute bottom-0",
            "scale-x-100 peer-focus:scale-x-100 peer-placeholder-shown:scale-x-0 duration-300"
          )}
        />
      </div>

      {/* Search icon button */}
      <button onClick={toggleInput} className="ps-1">
        <MdOutlineSearch className="text-xl" />
      </button>
    </div>
  );
};

export default SearchBar;
