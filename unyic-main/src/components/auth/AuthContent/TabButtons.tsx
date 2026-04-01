import clsx from "clsx";
import type { AuthActiveTab } from "../../../types/modal";

interface TabButtonsProps {
  activeTab: AuthActiveTab;
  setActiveTab: (tab: AuthActiveTab) => void;
}

const TABS: { key: AuthActiveTab; label: string }[] = [
  { key: "login", label: "Login" },
  { key: "signup", label: "Sign Up" },
];

const TabButtons = ({ activeTab, setActiveTab }: TabButtonsProps) => {
  return (
    <div className="border-b-2 grid grid-cols-2 items-center justify-center relative z-0">
      {TABS.map(({ key, label }) => (
        <button
          key={key}
          onClick={() => setActiveTab(key)}
          className={clsx(
            "pb-2 text-center font-semibold transition-colors duration-200",
            activeTab === key && "text-primary-dark"
          )}
        >
          {label}
        </button>
      ))}

      {/* Animated underline */}
      <div
        className={clsx(
          "w-1/2 h-[2px] bg-primary-dark absolute z-10 inset-0 top-full",
          {
            "translate-x-0": activeTab === "login",
            "translate-x-full": activeTab === "signup",
          },
          "transition-transform duration-300"
        )}
      />
    </div>
  );
};

export default TabButtons;
