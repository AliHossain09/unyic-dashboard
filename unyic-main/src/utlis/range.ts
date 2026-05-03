export const isSameRange = (a: [number, number], b: [number, number]) =>
  a[0] === b[0] && a[1] === b[1];

export const sanitizeRange = (
  value: string | null,
  defaultRange: [number, number],
): [number, number] => {
  const [defaultMin, defaultMax] = defaultRange;

  if (!value || !value.includes("-")) {
    return defaultRange;
  }

  // Extract raw parts
  const [rawMin, rawMax] = value.split("-");

  // Parse integers safely
  const min = parseInt(rawMin, 10);
  const max = parseInt(rawMax, 10);

  const validMin = !isNaN(min);
  const validMax = !isNaN(max);

  // Completely invalid
  if (!validMin && !validMax) {
    return defaultRange;
  }

  // Partially valid: only max valid
  if (!validMin && validMax) {
    const cleanedMax = Math.min(max, defaultMax);
    if (cleanedMax < defaultMin) {
      return defaultRange;
    }
    return [defaultMin, cleanedMax];
  }

  // Partially valid: only min valid
  if (validMin && !validMax) {
    const cleanedMin = Math.max(min, defaultMin);
    if (cleanedMin > defaultMax) {
      return defaultRange;
    }
    return [cleanedMin, defaultMax];
  }

  // Both valid: apply clamping
  const cleanedMin = Math.max(min, defaultMin);
  const cleanedMax = Math.min(max, defaultMax);

  // Reversed or invalid range after clamping
  if (cleanedMin > cleanedMax) {
    return defaultRange;
  }

  return [cleanedMin, cleanedMax];
};
